<?php

namespace App\Livewire\Auth;

use App\Models\OtpCode;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.auth')]
#[Title('ورود')]
class Login extends Component
{
    public string $loginMethod = 'password'; // 'password' or 'otp'
    public string $authType = 'password'; // 'password', 'otp', 'both'

    // Password login
    public string $identifier = ''; // Email or Phone
    public string $password = '';

    // Phone OTP login
    public string $phone = '';
    public string $code = '';
    public bool $codeSent = false;
    public int $countdown = 0;

    protected $messages = [
        'phone.required' => 'شماره موبایل الزامی است',
        'phone.regex' => 'فرمت شماره موبایل صحیح نیست',
        'code.required' => 'کد تأیید الزامی است',
        'code.digits' => 'کد تأیید باید ۶ رقم باشد',
        'identifier.required' => 'ایمیل یا شماره موبایل الزامی است',
        'password.required' => 'رمز عبور الزامی است',
    ];

    public function mount(): void
    {
        $this->authType = Setting::get('auth_type', 'password');
        
        // Set login method based on auth type
        if ($this->authType === 'otp') {
            $this->loginMethod = 'otp';
        } else {
            $this->loginMethod = 'password';
        }
    }

    public function switchMethod(string $method)
    {
        // Only allow switching if auth_type is 'both'
        if ($this->authType !== 'both') {
            return;
        }
        
        $this->loginMethod = $method;
        $this->resetErrorBag();
    }

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['phone', 'code', 'identifier'])) {
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

    // ── Password Login (Email or Phone) ──

    public function loginWithPassword()
    {
        $throttleKey = 'login-attempt:' . $this->identifier . '|' . request()->ip();
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            $this->addError('identifier', "تعداد دفعات تلاش بیش از حد مجاز است. لطفاً $seconds ثانیه صبر کنید.");
            return;
        }

        $this->validate([
            'identifier' => 'required',
            'password' => 'required|min:6',
        ]);

        $fieldType = filter_var($this->identifier, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        if (Auth::attempt([$fieldType => $this->identifier, 'password' => $this->password, 'is_active' => true], true)) {
            RateLimiter::clear($throttleKey);

            $deviceError = $this->checkMaxDevices(Auth::user());
            if ($deviceError) {
                Auth::logout();
                session()->invalidate();
                session()->regenerateToken();
                $this->addError('identifier', $deviceError);
                return;
            }

            return redirect()->intended('/');
        }

        RateLimiter::hit($throttleKey, 60);
        $this->addError('identifier', 'اطلاعات ورود (ایمیل/شماره یا رمز عبور) اشتباه است یا حساب کاربری شما غیرفعال شده است');
    }

    // ── Phone OTP Login ──

    public function sendCode()
    {
        $throttleKey = 'otp-send:' . $this->phone . '|' . request()->ip();
        if (RateLimiter::tooManyAttempts($throttleKey, 3)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            $this->addError('phone', "لطفاً $seconds ثانیه صبر کنید.");
            return;
        }

        $this->validate(['phone' => 'required|regex:/^09[0-9]{9}$/']);

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
        $this->countdown = 120;

        $this->dispatch('start-countdown');
    }

    public function verify()
    {
        $throttleKey = 'otp-verify:' . $this->phone . '|' . request()->ip();
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            $this->addError('code', "تعداد دفعات تلاش بیش از حد مجاز است. لطفاً $seconds ثانیه صبر کنید.");
            return;
        }

        $this->validate([
            'phone' => 'required|regex:/^09[0-9]{9}$/',
            'code' => 'required|digits:6',
        ]);

        if (!OtpCode::verify($this->phone, $this->code)) {
            RateLimiter::hit($throttleKey, 60);
            $this->addError('code', 'کد وارد شده نامعتبر است');
            return;
        }

        RateLimiter::clear($throttleKey);

        $user = User::firstOrCreate(
            ['phone' => $this->phone],
            [
                'name' => 'کاربر جدید',
                'phone_verified_at' => now(),
                'type' => 'listener',
            ]
        );

        if (!$user->phone_verified_at) {
            $user->update(['phone_verified_at' => now()]);
        }

        Auth::login($user, true);

        $deviceError = $this->checkMaxDevices($user);
        if ($deviceError) {
            Auth::logout();
            session()->invalidate();
            session()->regenerateToken();
            $this->addError('phone', $deviceError);
            return;
        }

        return redirect()->intended('/');
    }

    public function render()
    {
        return view('livewire.auth.login');
    }

    /**
     * Check if the user can log in on a new device without exceeding their plan's limit.
     * Returns null if login is allowed, or a Persian error message if the limit is reached.
     *
     * "Online" = session last_activity is within the configured session lifetime.
     */
    private function checkMaxDevices(User $user): ?string
    {
        if (! $user->isPremium()) {
            return null;
        }

        $plan       = $user->activeSubscription?->plan;
        $maxDevices = $plan?->max_devices ?? 1;

        // Consider a session "online" if active within the configured session lifetime
        $lifetimeSeconds  = (int) config('session.lifetime', 120) * 60;
        $onlineThreshold  = now()->timestamp - $lifetimeSeconds;
        $currentSessionId = session()->getId();

        $activeCount = DB::table('sessions')
            ->where('user_id', $user->id)
            ->where('id', '!=', $currentSessionId)
            ->where('last_activity', '>', $onlineThreshold)
            ->count();

        if ($activeCount >= $maxDevices) {
            return "پلن شما اجازه ورود همزمان از {$maxDevices} دستگاه را دارد. لطفاً ابتدا از دستگاه‌های دیگر خارج شوید.";
        }

        return null;
    }
}
