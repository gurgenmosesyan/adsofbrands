<?php

use App\Models\Agency\Agency;

return [
    'images' => [
        'path' => '/'.Agency::IMAGES_PATH,
        'image' => [
            'extensions' => [
                'jpg', 'jpeg', 'png'
            ],
            //'width' => 560,
            //'height' => 335,
            //'min_width' => 500,
            //'max_width' => 200,
            //'min_height' => 500,
            //'max_height' => 200,
        ],
        'cover' => [
            'extensions' => [
                'jpg', 'jpeg', 'png'
            ],
            //'width' => 560,
            //'height' => 335,
            //'min_width' => 500,
            //'max_width' => 200,
            //'min_height' => 500,
            //'max_height' => 200,
        ]
    ]
];