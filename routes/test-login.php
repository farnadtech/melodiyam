<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

$email = $_GET['email'] ?? 'user@melodiyam.ir';
$password = $_GET['password'] ?? 'password';

$user = \App\Models\User::where('email', $email)->first();

if (!$user) {
    echo "User not found: $email\n";
    exit;
}

echo "=== User Found ===\n";
echo "Email: " . $user->email . "\n";
echo "Name: " . $user->name . "\n";
echo "Type: " . $user->type . "\n";
echo "is_active: " . ($user->is_active ? 'YES' : 'NO') . "\n";
echo "email_verified_at: " . ($user->email_verified_at ?? 'NULL') . "\n";
echo "Password hash: " . substr($user->password, 0, 30) . "...\n";
echo "Hash check: " . (Hash::check($password, $user->password) ? 'PASS' : 'FAIL') . "\n";

// Try actual auth
$auth = Auth::attempt(['email' => $email, 'password' => $password]);
echo "Auth::attempt: " . ($auth ? 'SUCCESS' : 'FAILED') . "\n";

if (!$auth) {
    // Try with is_active check
    echo "\n=== Debug ===\n";
    echo "is_active value: " . var_export($user->is_active, true) . "\n";
    echo "is_active type: " . gettype($user->is_active) . "\n";
}
