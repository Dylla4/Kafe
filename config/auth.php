<?php

return [
    'defaults' => [
        'guard' => 'web', // Default untuk pelanggan
        'passwords' => 'users',
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
        // Tambahkan guard admin ini
        'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],
        // Arahkan ke model Admin Anda
        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\Admin::class,
        ],
    ],
    
    // ... pastikan semua kurung tutup ']' sudah lengkap sampai akhir file
];