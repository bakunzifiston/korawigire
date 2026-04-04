<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Listings staff account (AdminUserSeeder)
    |--------------------------------------------------------------------------
    |
    | Used by the database seeder only. After changing .env, run:
    | php artisan config:clear
    | php artisan db:seed --class=AdminUserSeeder --force
    |
    */

    'admin_email' => env('ADMIN_EMAIL', ''),
    'admin_password' => env('ADMIN_PASSWORD', ''),

];
