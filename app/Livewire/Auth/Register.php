<?php

namespace App\Livewire\Auth;

use App\Models\OtpCode;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.auth')]
#[Title('ثبت‌نام - ملودیام')]
class Register extends Component
{
    public string $name = '';
    public string $phone = '';
    public string $code = '';
    public bool $codeSent = false;

    protected function rules()
    {
        return [
            'name' => 'required|min:2|max:50',
            'phone' => 'required|regex:/^09[0-9]{9}$/|unique:users,phone',
            'code' => 'required|digits:6',
        ];
    }

    protected $messages = [
        'name.required' => 'نام الزامی است',
        'name.min' => 'نام حداقل ۲ کاراکتر باشد',
        'phone.required' => 'شماره موبایل الزامی است',
        'phone.regex' => 'فرمت شماره موبایل صحیح نیست',
        'phone.unique' => 'این شماره قبلاً ثبت شده است',
        'code.required' => 'کد تأیید الزامی است',
        'code.digits' => 'کد تأیید باید ۶ رقم باشد',
    ];

    public function sendCode()
    {
        $this->validateOnly('phone');
        $this->validateOnly('name');

        $otp = OtpCode::generate($this->phone);
        $this->codeSent = true;
        $this->dispatch('start-countdown');
    }

    public function register()
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
