<?php

namespace App\Core\Helpers;

class Meta
{
    protected $title = null;
    protected $template = null;
    protected $description = null;
    protected $keywords = null;
    protected $ogTitle = null;
    protected $ogDescription = null;
    protected $ogImage = null;
    protected $ogUrl = null;

    public function title($value, $template = true)
    {
        $this->title = $value;
        $this->template = $template;
    }

    public function description($value)
    {
        $this->description = $value;
    }

    public function keywords($value)
    {
        $this->keywords = $value;
    }

    public function ogTitle($value)
    {
        $this->ogTitle = $value;
    }

    public function ogDescription($value)
    {
        $this->ogDescription = $value;
    }

    public function ogImage($value)
    {
        $this->ogImage = $value;
    }

    public function ogUrl($value)
    {
        $this->ogUrl = $value;
    }

    /*********************************************************/

    public function getTitle($template)
    {
        return $this->template ? str_replace('{title}', $this->title, $template) : $this->title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getKeywords()
    {
        return $this->keywords;
    }

    public function getOgTitle()
    {
        return $this->ogTitle;
    }

    public function getOgDescription()
    {
        return $this->ogDescription;
    }

    public function getOgImage()
    {
        return $this->ogImage;
    }

    public function getOgUrl()
    {
        return $this->ogUrl;
    }
}