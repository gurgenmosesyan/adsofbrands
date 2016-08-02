<?php

namespace App\Models\Background;

use App\Core\Image\SaveImage;

class Manager
{
    public function update($data)
    {
        $background = Background::first();

        if ($background == null) {
            $background = new Background();
            SaveImage::save($data['homepage'], $background, 'homepage');
            SaveImage::save($data['about'], $background, 'about');
            SaveImage::save($data['accommodation'], $background, 'accommodation');
            SaveImage::save($data['offer'], $background, 'offer');
            SaveImage::save($data['facility'], $background, 'facility');
            SaveImage::save($data['event'], $background, 'event');
            $background->save();
        } else {
            $homepage = SaveImage::save($data['homepage'], $background, 'homepage');
            $about = SaveImage::save($data['about'], $background, 'about');
            $accommodation = SaveImage::save($data['accommodation'], $background, 'accommodation');
            $offer = SaveImage::save($data['offer'], $background, 'offer');
            $facility = SaveImage::save($data['facility'], $background, 'facility');
            $event = SaveImage::save($data['event'], $background, 'event');
            Background::getProcessor()->delete();
            $background = new Background();
            $background->homepage = $homepage;
            $background->about = $about;
            $background->accommodation = $accommodation;
            $background->offer = $offer;
            $background->facility = $facility;
            $background->event = $event;
            $background->save();
        }
    }
}