<?php

namespace App\Livewire\Auth;

use App\Models\OtpCode;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.auth')]
#[Title('ورود - ملودیام')]
class Login extends Component
{
    public string $loginMethod = 'email'; // 'email' or 'phone'
    public string $authType = 'password'; // 'password' or 'otp' - from settings

    // Email login
    public string $email = '';
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
        'email.required' => 'ایمیل الزامی است',
        'email.email' => 'فرمت ایمیل صحیح نیست',
        'password.required' => 'رمز عبور الزامی است',
    ];

    public function mount(): void
    {
        $this->authType = Setting::get('auth_type', 'password');
        
        // Set login method based on auth type
        if ($this->authType === 'otp') {
            $this->loginMethod = 'phone';
        } else {
            $this->loginMethod = 'email';
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
        
        $this->loginMethod = $method;
        $this->resetErrorBag();
    }

    // ── Email Login ──

    public function loginWithEmail()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], true)) {
            return redirect()->intended('/');
        }

        $this->addError('email', 'ایمیل یا رمز عبور اشتباه است');
    }

    // ── Phone OTP Login ──

    public function sendCode()
    {
        $this->validate(['phone' => 'required|regex:/^09[0-9]{9}$/']);

        $otp = OtpCode::generate($this->phone);

        // TODO: Send SMS via MelliPayamak
        // SmsService::send($this->phone, "کد تأیید ملودیام: {$otp->code}");

        $this->codeSent = true;
        $this->countdown = 120;

        $this->dispatch('start-countdown');
    }

    public function verify()
    {
        $this->validate([
            'phone' => 'required|regex:/^09[0-9]{9}$/',
            'code' => 'required|digits:6',
        ]);

        if (!OtpCode::verify($this->phone, $this->code)) {
            $this->addError('code', 'کد وارد شده نامعتبر است');
            return;
        }

        $user = User::firstOrCreate(
            ['phone' => $this->phone],
            [
                'name' => 'کاربر ملودیام',
                'phone_verified_at' => now(),
                'type' => 'listener',
            ]
        );

        if (!$user->phone_verified_at) {
            $user->update(['phone_verified_at' => now()]);
        }

        Auth::login($user, true);

        return redirect()->intended('/');
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
