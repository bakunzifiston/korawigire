<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Create or update a listings moderator account from ADMIN_EMAIL / ADMIN_PASSWORD in .env.
     */
    public function run(): void
    {
        $email = (string) env('ADMIN_EMAIL', '');
        $password = (string) env('ADMIN_PASSWORD', '');

        if ($email === '' || $password === '') {
            $this->command?->warn('Skipping AdminUserSeeder: set ADMIN_EMAIL and ADMIN_PASSWORD in .env');

            return;
        }

        $user = User::firstOrNew(['email' => $email]);
        if (! $user->exists) {
            $user->name = 'Listings Admin';
        }
        $user->password = Hash::make($password);
        $user->is_admin = true;
        $user->save();

        $this->command?->info('Listings admin user ready: '.$email);
    }
}
