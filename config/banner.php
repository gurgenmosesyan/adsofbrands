<?php

use App\Models\Banner\Banner;

return [
    'images' => [
        'path' => '/'.Banner::IMAGES_PATH,
        '1' => [
            'extensions' => [
                'jpg', 'jpeg', 'png', 'gif'
            ],
            'width' => 728,
            'height' => 90,
            //'min_width' => 500,
            //'max_width' => 200,
            //'min_height' => 500,
            //'max_height' => 200,
        ],
        '2' => [
            'extensions' => [
                'jpg', 'jpeg', 'png', 'gif'
            ],
            'width' => 728,
            'height' => 90,
        ],
        '3' => [
            'extensions' => [
                'jpg', 'jpeg', 'png', 'gif'
            ],
            'width' => 312,
            'height' => 400,
        ],
        '4' => [
            'extensions' => [
                'jpg', 'jpeg', 'png', 'gif'
            ],
            'width' => 240,
            'height' => 400,
        ]
    ]
];