<?php

use App\Models\Commercial\Commercial;

return [
    'images' => [
        'path' => '/'.Commercial::IMAGES_PATH,
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
        'image_print' => [
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