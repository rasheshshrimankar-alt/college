<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

class RenderAdminSeeder extends Seeder
{
    public function run(): void
    {
        $email = env('INITIAL_ADMIN_EMAIL');
        $password = env('INITIAL_ADMIN_PASSWORD');

        if (! $email || ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new RuntimeException('Set a valid INITIAL_ADMIN_EMAIL before creating the Render administrator.');
        }

        if (! $password || strlen($password) < 10) {
            throw new RuntimeException('Set INITIAL_ADMIN_PASSWORD to a password with at least 10 characters.');
        }

        $admin = User::updateOrCreate(
            ['email' => $email],
            [
                'name' => env('INITIAL_ADMIN_NAME', 'Rashesh'),
                'phone' => null,
                'role' => 'admin',
                'password' => Hash::make($password),
                'status' => 'active',
            ]
        );
    }
}
