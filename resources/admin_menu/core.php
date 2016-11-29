<?php

return [
    [
        'key' => 'system',
        'icon' => 'fa-wrench',
        'sub_menu' => [
            [
                'key' => 'admin',
                'path' => route('core_admin_table'),
                'icon' => 'fa-user',
            ],
            [
                'key' => 'language',
                'icon' => 'fa-flag',
                'path' => route('core_language_table'),
            ],
            [
                'key' => 'dictionary',
                'icon' => 'fa-book',
                'path' => route('core_dictionary_table'),
            ]
        ]
    ]
];