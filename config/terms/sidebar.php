<?php

return [
    'dashboard' => [
        'title' => 'Dashboard',
        'route' => '/dashboard',
        'icon' => 'fa fa-th-large',
        'sub_menu' => []
    ],
    'back-links' => [
        'title' => 'Back Links',
        'route' => '#',
        'icon' => 'fa fa-bar-chart-o',
        'sub_menu' => [
            'text-link' => [
                'title' => 'Text Link',
                'route' => '/back-links/text-link/index',
            ],
            'guest-post' => [
                'title' => 'Guest Post',
                'route' => '/back-links/guest-post/index',
            ]
        ]
    ],
    'website' => [
        'title' => 'Mange Website',
        'route' => '/website/index',
        'icon' => 'fa fa-star',
        'sub_menu' => []
    ],
    'ctv' => [
        'title' => 'CTV',
        'route' => '/ctv/index',
        'icon' => 'fa fa-handshake-o',
        'sub_menu' => []
    ]
];
