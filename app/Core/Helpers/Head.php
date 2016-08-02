<?php

namespace App\Core\Helpers;

class Head
{
    private static $instance = null;
    private $mainStyles = [];
    private $mainScripts = [];
    private $styles = [];
    private $scripts = [];
    private $stylesVersion;
    private $scriptsVersion;

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function __construct()
    {
        $this->stylesVersion = env('STYLES_VERSION', 1);
        $this->scriptsVersion = env('SCRIPTS_VERSION', 1);
    }

    public function appendMainStyle($path)
    {
        $this->mainStyles[] = '<link href="'.$path.'?v='.$this->stylesVersion.'" media="screen" rel="stylesheet" type="text/css" />';
    }

    public function appendMainScript($path)
    {
        $this->mainScripts[] = '<script src="'.$path.'?v='.$this->scriptsVersion.'" type="text/javascript"></script>';
    }

    public function appendStyle($path)
    {
        $this->styles[] = '<link href="'.$path.'?v='.$this->stylesVersion.'" media="screen" rel="stylesheet" type="text/css" />';
    }

    public function appendScript($path)
    {
        $this->scripts[] = '<script src="'.$path.'?v='.$this->scriptsVersion.'" type="text/javascript"></script>';
    }

    public function renderStyles()
    {
        foreach ($this->mainStyles as $style) {
            echo $style;
        }
        foreach ($this->styles as $style) {
            echo $style;
        }
    }

    public function renderScripts()
    {
        foreach ($this->mainScripts as $script) {
            echo $script;
        }
        foreach ($this->scripts as $script) {
            echo $script;
        }
    }
}