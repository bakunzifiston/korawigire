<?php

return [

    /*
    | Logo file name only — must live under public/{images.content_path}/ (see config/images.php).
    | Brand colors: green #00A651, red #E31E24, black #000000, white #FFFFFF
    */
    'logo' => 'logo.png',

    'company' => 'Kora Wigire Multi Services & Money Radio Ltd',
    'short_name' => 'Kora Wigire',
    'tagline' => 'korawigire ltd',
    'website' => 'https://www.korawigire.rw',
    'phone' => '+250 788 715 657',
    'phone_tel' => '+250788715657',
    'email' => 'korawigire0@gmail.com',
    'location' => 'Rubavu District, Rwanda',

    'social' => [
        'facebook' => 'https://www.facebook.com/',
        'instagram' => 'https://www.instagram.com/',
        'whatsapp' => 'https://wa.me/250788715657',
    ],

    /** KORA Inventory Management System — staff login */
    'ims_login_url' => 'https://ims.korawigire.rw/login',

    /** KORA IMS — student / training application form */
    'ims_application_url' => 'https://ims.korawigire.rw/application',

    /*
    | Home banner slider — paths under public/images/ (see site_image()).
    | Use photos with a white or very light background so they read well on the dark hero.
    | Edit this list to match your actual files (or add files under public/images/hero/).
    */
    'hero_slide_images' => [
        'gallery/IMG-20250602-WA0052.jpg',
        'gallery/IMG-20250602-WA0050.jpg',
        'gallery/IMG-20250602-WA0049.jpg',
        'gallery/IMG-20250602-WA0056.jpg',
        'gallery/IMG-20250602-WA0053.jpg',
    ],

    /*
    | Matomo analytics — leave MATOMO_SITE_ID empty in .env to disable tracking.
    */
    'matomo' => [
        'url' => rtrim((string) env('MATOMO_URL', 'https://analytics.redp.rw'), '/').'/',
        'site_id' => env('MATOMO_SITE_ID', '9'),
    ],

];
