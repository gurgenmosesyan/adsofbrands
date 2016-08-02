<?php

use App\Models\Accommodation\Accommodation;

return [
    'accommodation' => [
        'path' => '/'.Accommodation::IMAGES_PATH,
        'thumb' => [
            'width' => '330',
            'height' => '227',
            'crop' => 'center'
        ],
        'booking' => [
            'width' => '170',
            'height' => '65',
            'crop' => 'center'
        ]
    ]
];