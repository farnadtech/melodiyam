<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CreateTestUser extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'کاربر تست',
                'email' => 'user@melodiyam.ir',
                'password' => Hash::make('password'),
                'type' => 'listener',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
        ];

        foreach ($users as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                $data
            );
            $user->assignRole('listener');
            echo "Created/Updated: " . $user->email . "\n";
        }
    }
}
