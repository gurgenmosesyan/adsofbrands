<?php

use App\Models\MediaType\MediaType;

return [
    'images' => [
        'path' => '/'.MediaType::IMAGES_PATH,
        'icon' => [
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