<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Create or update a listings moderator account from ADMIN_EMAIL / ADMIN_PASSWORD in .env.
     *
     * Password is assigned in plain text; the User model's "hashed" cast stores it correctly.
     */
    public function run(): void
    {
        $email = (string) config('staff.admin_email', '');
        $password = (string) config('staff.admin_password', '');

        if ($email === '' || $password === '') {
            $this->command?->warn('Skipping AdminUserSeeder: set ADMIN_EMAIL and ADMIN_PASSWORD in .env, then run: php artisan config:clear');

            return;
        }

        $user = User::firstOrNew(['email' => $email]);
        if (! $user->exists) {
            $user->name = 'Listings Admin';
        }

        $user->password = $password;
        $user->is_admin = true;
        $user->save();

        $this->command?->info('Listings admin user ready: '.$email);
    }
}
