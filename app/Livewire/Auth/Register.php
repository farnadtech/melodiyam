<?php

namespace App\Livewire\Auth;

use App\Models\OtpCode;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.auth')]
#[Title('ثبت‌نام - ملودیام')]
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

    // ── Email/Password Registration ──

    public function registerWithEmail()
    {
        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => bcrypt($this->password),
            'type' => 'listener',
        ]);

        Auth::login($user, true);

        return redirect()->intended('/');
    }

    // ── Phone OTP Registration ──

    public function sendCode()
    {
        $this->validateOnly('phone');
        $this->validateOnly('name');

        $otp = OtpCode::generate($this->phone);
        $this->codeSent = true;
        $this->dispatch('start-countdown');
    }

    public function registerWithPhone()
    {
        $this->validate();

        if (!OtpCode::verify($this->phone, $this->code)) {
            $this->addError('code', 'کد وارد شده نامعتبر است');
            return;
        }

        $user = User::create([
            'name' => $this->name,
            'phone' => $this->phone,
            'phone_verified_at' => now(),
            'type' => 'listener',
        ]);

        Auth::login($user, true);

        return redirect()->intended('/');
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
