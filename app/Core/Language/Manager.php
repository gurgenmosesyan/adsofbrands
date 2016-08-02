<?php

namespace App\Core\Language;

use App\Core\Image\SaveImage;

class Manager
{
    private static $currentLanguage = null;

    public function getCurrentLanguage()
    {
        if (self::$currentLanguage === null) {
            $defaultLng = Language::defaultLng()->firstOrFail();
            $this->setCurrentLanguage($defaultLng);
        }
        return self::$currentLanguage;
    }

    public function setCurrentLanguage(Language $language)
    {
        app()->setLocale($language->code);
        self::$currentLanguage = $language;
    }

    public function setCurrentLanguageById($lngId)
    {
        $language = Language::find($lngId);
	    if ($language != null) {
		    $this->setCurrentLanguage($language);
	    }
    }

    public function setCurrentLanguageByCode($lngCode)
    {
        $language = Language::where('code', $lngCode)->firstOrFail();
        $this->setCurrentLanguage($language);
    }

    public function store($data)
    {
        $data = $this->processSave($data);
        $language = new Language($data);
        SaveImage::save($data['icon'], $language, 'icon');
        $language->save();
        $this->updateDefault($language);
        return $language;
    }

    public function update($id, $data)
    {
        $language = Language::findOrFail($id);
        SaveImage::save($data['icon'], $language, 'icon');
        $data = $this->processSave($data);
        $language->update($data);
        $this->updateDefault($language);
        return $language;
    }

    protected function processSave($data)
    {
        if (!isset($data['default'])) {
            $data['default'] = Language::NOT_DEFAULT_LNG;
        }
        return $data;
    }

    protected function updateDefault(Language $language)
    {
        if ($language->default == Language::DEFAULT_LNG) {
            Language::where('id', '!=', $language->id)->update(['default' => Language::NOT_DEFAULT_LNG]);
        } else {
            Language::where('code', 'en')->update(['default' => Language::DEFAULT_LNG]);
        }
    }

    public function delete($id)
    {
        Language::where('id', $id)->delete();
        return true;
    }
}