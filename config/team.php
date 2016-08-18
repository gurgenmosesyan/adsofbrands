<?php

use App\Models\Team\Team;

return [
    'images' => [
        'path' => '/'.Team::IMAGES_PATH,
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
        ]
    ]
];