<?php

use App\Models\Creative\Creative;

return [
    'images' => [
        'path' => '/'.Creative::IMAGES_PATH,
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
        'cover' => [
            'extensions' => [
                'jpg', 'jpeg', 'png'
            ],
            'min_width' => 1250,
            'min_height' => 320,
        ]
    ]
];