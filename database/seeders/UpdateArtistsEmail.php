<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UpdateArtistsEmail extends Seeder
{
    public function run(): void
    {
        $artists = [
            ['phone' => '09121111111', 'email' => 'chavoshi@melodiyam.ir'],
            ['phone' => '09121111112', 'email' => 'sirvan@melodiyam.ir'],
            ['phone' => '09121111113', 'email' => 'behram@melodiyam.ir'],
            ['phone' => '09121111114', 'email' => 'homayoun@melodiyam.ir'],
            ['phone' => '09121111115', 'email' => 'hamed@melodiyam.ir'],
            ['phone' => '09121111116', 'email' => 'mehrad@melodiyam.ir'],
        ];

        foreach ($artists as $data) {
            $user = User::where('phone', $data['phone'])->first();
            if ($user) {
                $user->email = $data['email'];
                $user->password = Hash::make('password');
                $user->email_verified_at = now();
                $user->save();
                echo "Updated: " . $data['email'] . "\n";
            }
        }
    }
}
