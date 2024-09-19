<?php

return [
    'role_structure' => [
        'super_administrator' => [
            'role' => 'v,c,u',
            'user' => 'v,c,u,d',
            'master' => 'v,c,u,d',
            'report' => 'v,c,u,d',
            'asset' => 'v,c,u,d',
            'transaction' => 'v,c,u,d',
            'purchase' => 'v,c,u,d',
        ],
    ],
    'permission_structure' => [],
    'permissions_map' => [
        'v' => 'view',
        'c' => 'create',
        'u' => 'update',
        'd' => 'delete',
    ],
];

// php artisan db:seed --class=LaratrustSeeder
