<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OtpCode;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function sendCode(Request $request): JsonResponse
    {
        $request->validate(['phone' => 'required|regex:/^09[0-9]{9}$/']);

        OtpCode::generate($request->phone);

        return response()->json(['message' => 'کد تأیید ارسال شد', 'success' => true]);
    }

    public function verify(Request $request): JsonResponse
    {
        $request->validate([
            'phone' => 'required|regex:/^09[0-9]{9}$/',
            'code' => 'required|digits:6',
        ]);

        if (!OtpCode::verify($request->phone, $request->code)) {
            return response()->json(['message' => 'کد نامعتبر است', 'success' => false], 422);
        }

        $user = User::firstOrCreate(
            ['phone' => $request->phone],
            ['name' => 'کاربر ملودیام', 'phone_verified_at' => now(), 'type' => 'listener']
        );

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'token' => $token,
            'user' => $user->only(['id', 'name', 'phone', 'type', 'is_premium']),
        ]);
    }

    public function me(Request $request): JsonResponse
    {
        return response()->json(['user' => $request->user()]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'خروج با موفقیت انجام شد']);
    }
}
