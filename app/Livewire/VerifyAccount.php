<?php

namespace App\Livewire;

use App\Models\OtpCode;
use App\Models\Setting;
use App\Models\User;
use App\Services\NotificationDispatcher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.auth')]
#[Title('احراز هویت')]
class VerifyAccount extends Component
{
    public bool $requireEmail = false;
    public bool $requirePhone = false;

    // Phone verification
    public string $phone = '';
    public string $phoneCode = '';
    public bool $phoneCodeSent = false;
    public int $phoneCountdown = 0;
    public bool $phoneVerified = false;

    // Email verification
    public string $email = '';
    public string $emailCode = '';
    public bool $emailCodeSent = false;
    public int $emailCountdown = 0;
    public bool $emailVerified = false;

    public function mount(): void
    {
        $user = Auth::user();
        if (!$user) {
            $this->redirectRoute('login');
            return;
        }

        $this->requireEmail = Setting::get('email_verification', '0') === '1';
        $this->requirePhone = Setting::get('phone_verification', '0') === '1';

        // Pre-fill from user data
        $this->phone = $user->phone ?? '';
        $this->email = $user->email ?? '';

        // Check if already verified
        $this->phoneVerified = (bool) $user->phone_verified_at;
        $this->emailVerified = (bool) $user->email_verified_at;

        // If everything is verified, redirect
        $this->checkComplete();
    }

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['phone', 'phoneCode', 'emailCode'])) {
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

    public function sendPhoneCode(): void
    {
        $this->validate(['phone' => 'required|regex:/^09[0-9]{9}$/']);

        $otpSetting = \App\Models\NotificationSetting::where('event_key', 'otp_code')->first();
        if (!$otpSetting || !$otpSetting->via_sms) {
            $this->addError('phone', 'ارسال کد تایید پیامکی در حال حاضر غیرفعال است.');
            return;
        }

        // Update user phone if changed
        $user = Auth::user();
        if ($user->phone !== $this->phone) {
            $exists = User::where('phone', $this->phone)->where('id', '!=', $user->id)->exists();
            if ($exists) {
                $this->addError('phone', 'این شماره قبلاً ثبت شده است.');
                return;
            }
            $user->update(['phone' => $this->phone]);
        }

        $otp = OtpCode::generate($this->phone);
        NotificationDispatcher::dispatch('otp_code', ['code' => $otp->code], (object)['phone' => $this->phone]);

        $this->phoneCodeSent = true;
        $this->phoneCountdown = 120;
        $this->dispatch('start-phone-countdown');
    }

    public function verifyPhone(): void
    {
        $this->validate(['phoneCode' => 'required|digits:6']);

        if (!OtpCode::verify($this->phone, $this->phoneCode)) {
            $this->addError('phoneCode', 'کد وارد شده نامعتبر است');
            return;
        }

        Auth::user()->update(['phone_verified_at' => now()]);
        $this->phoneVerified = true;
        $this->checkComplete();
    }

    public function sendEmailCode(): void
    {
        $this->validate(['email' => 'required|email']);

        $user = Auth::user();
        if ($user->email !== $this->email) {
            $exists = User::where('email', $this->email)->where('id', '!=', $user->id)->exists();
            if ($exists) {
                $this->addError('email', 'این ایمیل قبلاً ثبت شده است.');
                return;
            }
            $user->update(['email' => $this->email]);
        }

        // Generate OTP for email
        $otp = OtpCode::generate($this->email);
        
        try {
            Mail::raw("کد تایید ایمیل شما: {$otp->code}", function ($message) {
                $message->to($this->email)
                    ->subject('کد تایید ایمیل - ' . config('app.name'));
            });
        } catch (\Exception $e) {
            $this->addError('email', 'خطا در ارسال ایمیل. لطفاً بعداً تلاش کنید.');
            return;
        }

        $this->emailCodeSent = true;
        $this->emailCountdown = 120;
        $this->dispatch('start-email-countdown');
    }

    public function verifyEmail(): void
    {
        $this->validate(['emailCode' => 'required|digits:6']);

        if (!OtpCode::verify($this->email, $this->emailCode)) {
            $this->addError('emailCode', 'کد وارد شده نامعتبر است');
            return;
        }

        Auth::user()->update(['email_verified_at' => now()]);
        $this->emailVerified = true;
        $this->checkComplete();
    }

    protected function checkComplete(): void
    {
        $needsEmail = $this->requireEmail && !$this->emailVerified;
        $needsPhone = $this->requirePhone && !$this->phoneVerified;

        if (!$needsEmail && !$needsPhone) {
            // All done - redirect after a small delay
            $this->dispatch('verification-complete');
        }
    }

    public function render()
    {
        return view('livewire.verify-account');
    }
}
