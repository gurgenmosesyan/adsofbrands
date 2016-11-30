<?php

return [
    [
        'key' => 'options',
        'icon' => 'fa-pencil',
        'sub_menu' => [
            [
                'key' => 'media_type',
                'path' => route('admin_media_type_table'),
                'icon' => 'fa-pencil',
            ],
            [
                'key' => 'industry_type',
                'path' => route('admin_category_table'),
                'icon' => 'fa-pencil',
            ],
            [
                'key' => 'agency_category',
                'path' => route('admin_agency_category_table'),
                'icon' => 'fa-pencil',
            ]
        ]
    ],
    [
        'key' => 'brand',
        'path' => route('admin_brand_table'),
        'icon' => 'fa-btc',
    ],
    [
        'key' => 'agency',
        'path' => route('admin_agency_table'),
        'icon' => 'fa-briefcase',
    ],
    [
        'key' => 'commercial',
        'path' => route('admin_commercial_table'),
        'icon' => 'fa-bullhorn',
    ],
    [
        'key' => 'creative',
        'path' => route('admin_creative_table'),
        'icon' => 'fa-user',
    ],
    [
        'key' => 'award',
        'path' => route('admin_award_table'),
        'icon' => 'fa-gift',
    ],
    [
        'key' => 'vacancy',
        'path' => route('admin_vacancy_table'),
        'icon' => 'fa-cube',
    ],
    [
        'key' => 'branch',
        'path' => route('admin_branch_table'),
        'icon' => 'fa-sitemap',
    ],
    [
        'key' => 'news',
        'path' => route('admin_news_table'),
        'icon' => 'fa-rss',
    ],
    [
        'key' => 'team',
        'path' => route('admin_team_table'),
        'icon' => 'fa-group',
    ],
    [
        'key' => 'banner',
        'path' => route('admin_banner_table'),
        'icon' => 'fa-bookmark',
    ],
    [
        'key' => 'footer_menu',
        'path' => route('admin_footer_menu_table'),
        'icon' => 'fa-reorder',
    ],
    [
        'key' => 'short_link',
        'path' => route('admin_short_link_table'),
        'icon' => 'fa-link',
    ],
    [
        'key' => 'subscribe',
        'path' => route('admin_subscribe_table'),
        'icon' => 'fa-envelope',
    ],
];