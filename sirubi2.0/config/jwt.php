<?php

return [
    'key' => env('JWT_SECRET', 'S1rub1Bkt'),
    'algorithm' => 'HS256',

    // 15 menit
    'access_expire' => 15 * 60,

    // 7 hari
    'refresh_expire' => 7 * 24 * 60 * 60,
];
