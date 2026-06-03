<?php

namespace App\Livewire\Auth;

use App\Models\OtpCode;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Livewire\Component;

class ForgotPassword extends Component
{
    public string $method = 'email'; // 'email' or 'phone'
    public bool $otpEnabled = false;
    public string $authType = 'password';
    
    // Email method
    public string $email = '';
    public bool $sent = false;

    // Phone method
    public string $phone = '';
    public string $code = '';
    public bool $codeSent = false;
    public bool $codeVerified = false;
    public int $countdown = 0;

    // New Password (for OTP method)
    public string $password = '';
    public string $password_confirmation = '';

    public function mount(): void
    {
        $this->otpEnabled = (bool) \App\Models\NotificationSetting::where('event_key', 'password_recovery')->where('via_sms', true)->exists();
        $this->authType = Setting::get('auth_type', 'password');
        
        if ($this->authType === 'otp') {
            $this->method = 'phone';
        } else {
            // 'password' or 'both' — default to email
            $this->method = 'email';
        }
    }

    public function send(): void
    {
        if ($this->method === 'email') {
            $this->validate(['email' => 'required|email']);
            $status = Password::sendResetLink(['email' => $this->email]);

            if ($status === Password::RESET_LINK_SENT) {
                $this->sent = true;
            } else {
                $this->addError('email', __($status));
            }
        } else {
            $this->sendOtp();
        }
    }

    public function sendOtp(): void
    {
        $this->validate(['phone' => 'required|regex:/^09[0-9]{9}$/']);
        
        $user = User::where('phone', $this->phone)->first();
        if (!$user) {
            $this->addError('phone', 'کاربری با این شماره یافت نشد');
            return;
        }

        // Check if Password Recovery OTP is enabled in Notification Settings
        $recoverySetting = \App\Models\NotificationSetting::where('event_key', 'password_recovery')->first();
        if (!$recoverySetting || !$recoverySetting->via_sms) {
            $this->addError('phone', 'بازیابی رمز عبور از طریق پیامک در حال حاضر غیرفعال است.');
            return;
        }

        $otp = OtpCode::generate($this->phone);

        // Send SMS via NotificationDispatcher
        \App\Services\NotificationDispatcher::dispatch('password_recovery', [
            'code' => $otp->code,
        ], (object)['phone' => $this->phone]);

        $this->codeSent = true;
        $this->countdown = 120;
        $this->dispatch('start-countdown');
    }

    public function verifyOtp(): void
    {
        $this->validate(['code' => 'required|digits:6']);

        if (OtpCode::verify($this->phone, $this->code)) {
            $this->codeVerified = true;
        } else {
            $this->addError('code', 'کد وارد شده نامعتبر است');
        }
    }

    public function resetPassword()
    {
        $this->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::where('phone', $this->phone)->first();
        if ($user) {
            $user->update([
                'password' => Hash::make($this->password)
            ]);

            session()->flash('message', 'رمز عبور با موفقیت تغییر کرد. اکنون می‌توانید وارد شوید.');
            return redirect()->route('login');
        }
    }

    public function render()
    {
        return view('livewire.auth.forgot-password')
            ->layout('components.layouts.auth', ['title' => 'فراموشی رمز عبور']);
    }
}
