<?php

namespace App\Livewire\Auth;

use App\Models\OtpCode;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.auth')]
#[Title('ثبت‌نام')]
class Register extends Component
{
    public string $authType = 'password'; // 'password' or 'otp' - from settings
    public string $registerMethod = 'email'; // 'email' or 'phone'

    // Email/Password registration
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    // Phone OTP registration
    public string $phone = '';
    public string $code = '';
    public bool $codeSent = false;

    protected function rules()
    {
        if ($this->registerMethod === 'email') {
            return [
                'name' => 'required|min:2|max:50',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6|confirmed',
            ];
        }

        return [
            'name' => 'required|min:2|max:50',
            'phone' => 'required|regex:/^09[0-9]{9}$/|unique:users,phone',
            'code' => 'required|digits:6',
        ];
    }

    protected $messages = [
        'name.required' => 'نام الزامی است',
        'name.min' => 'نام حداقل ۲ کاراکتر باشد',
        'email.required' => 'ایمیل الزامی است',
        'email.email' => 'فرمت ایمیل صحیح نیست',
        'email.unique' => 'این ایمیل قبلاً ثبت شده است',
        'password.required' => 'رمز عبور الزامی است',
        'password.min' => 'رمز عبور حداقل ۶ کاراکتر باشد',
        'password.confirmed' => 'تکرار رمز عبور مطابقت ندارد',
        'phone.required' => 'شماره موبایل الزامی است',
        'phone.regex' => 'فرمت شماره موبایل صحیح نیست',
        'phone.unique' => 'این شماره قبلاً ثبت شده است',
        'code.required' => 'کد تأیید الزامی است',
        'code.digits' => 'کد تأیید باید ۶ رقم باشد',
    ];

    public function mount(): void
    {
        $this->authType = Setting::get('auth_type', 'password');
        
        // Set register method based on auth type
        if ($this->authType === 'otp') {
            $this->registerMethod = 'phone';
        } else {
            $this->registerMethod = 'email';
        }
    }

    public function switchMethod(string $method)
    {
        // Only allow switching if auth_type is not set to a specific method
        if ($this->authType === 'otp' && $method === 'email') {
            return;
        }
        if ($this->authType === 'password' && $method === 'phone') {
            return;
        }
        
        $this->registerMethod = $method;
        $this->resetErrorBag();
    }

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['phone', 'code'])) {
            $this->$propertyName = $this->convertPersianToEnglish($this->$propertyName);
        }
    }

    private function convertPersianToEnglish($string)
    {
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $arabic = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
        $english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

        $string = str_replace($persian, $english, $string);
        return str_replace($arabic, $english, $string);
    }

    // ── Email/Password Registration ──

    public function registerWithEmail()
    {
        $throttleKey = 'register-attempt:' . request()->ip();
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            $this->addError('email', "تعداد دفعات تلاش بیش از حد مجاز است. لطفاً $seconds ثانیه صبر کنید.");
            return;
        }

        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => bcrypt($this->password),
            'type' => 'listener',
        ]);

        Auth::login($user, true);
        RateLimiter::clear($throttleKey);

        return redirect()->intended('/');
    }

    // ── Phone OTP Registration ──

    public function sendCode()
    {
        $throttleKey = 'otp-send:' . $this->phone . '|' . request()->ip();
        if (RateLimiter::tooManyAttempts($throttleKey, 3)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            $this->addError('phone', "لطفاً $seconds ثانیه صبر کنید.");
            return;
        }

        $this->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|regex:/^09[0-9]{9}$/|unique:users,phone',
            'password' => 'required|min:8|confirmed',
        ], [
            'phone.unique' => 'این شماره موبایل قبلاً ثبت شده است',
        ]);

        // Check if OTP is enabled in Notification Settings
        $otpSetting = \App\Models\NotificationSetting::where('event_key', 'otp_code')->first();
        if (!$otpSetting || !$otpSetting->via_sms) {
            $this->addError('phone', 'ارسال کد تایید در حال حاضر غیرفعال است.');
            return;
        }

        $otp = OtpCode::generate($this->phone);

        // Send SMS via NotificationDispatcher
        \App\Services\NotificationDispatcher::dispatch('otp_code', [
            'code' => $otp->code,
        ], (object)['phone' => $this->phone]);

        RateLimiter::hit($throttleKey, 120);
        $this->codeSent = true;
        $this->dispatch('start-countdown');
    }

    public function registerWithPhone()
    {
        $throttleKey = 'otp-verify:' . $this->phone . '|' . request()->ip();
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            $this->addError('code', "تعداد دفعات تلاش بیش از حد مجاز است. لطفاً $seconds ثانیه صبر کنید.");
            return;
        }

        $this->validate();

        if (!OtpCode::verify($this->phone, $this->code)) {
            RateLimiter::hit($throttleKey, 60);
            $this->addError('code', 'کد وارد شده نامعتبر است');
            return;
        }

        $user = User::create([
            'name' => $this->name,
            'phone' => $this->phone,
            'password' => Hash::make($this->password),
            'phone_verified_at' => now(),
            'type' => 'listener',
        ]);

        Auth::login($user, true);
        RateLimiter::clear($throttleKey);

        return redirect()->intended('/');
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
