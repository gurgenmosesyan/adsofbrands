<?php

use App\Models\Commercial\Commercial;

return [
    'images' => [
        'path' => '/'.Commercial::IMAGES_PATH,
        'image' => [
            'extensions' => [
                'jpg', 'jpeg', 'png'
            ],
            'width' => 150,
            'height' => 150,
            //'min_width' => 500,
            //'max_width' => 200,
            //'min_height' => 500,
            //'max_height' => 200,
        ],
        'image_print' => [
            'extensions' => [
                'jpg', 'jpeg', 'png'
            ],
            'min_width' => 690,
            'max_width' => 2000,
            'max_height' => 2000,
        ]
    ]
];