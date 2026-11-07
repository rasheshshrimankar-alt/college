<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
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

        if (! $password || strlen($password) < 12) {
            throw new RuntimeException('Set INITIAL_ADMIN_PASSWORD to a unique password with at least 12 characters.');
        }

        $admin = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => env('INITIAL_ADMIN_NAME', 'College Administrator'),
                'phone' => null,
                'role' => 'admin',
                'password' => Hash::make($password),
                'status' => 'active',
            ]
        );

        // Ensure the selected account has administrator access without resetting
        // its password on subsequent container restarts.
        $admin->forceFill([
            'role' => 'admin',
            'status' => 'active',
        ])->save();
    }
}
