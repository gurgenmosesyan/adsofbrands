<?php

use App\Core\Language\Manager as LngManager;

function queryDump(callable $fn) {
    DB::enableQueryLog();
    $fn();
    dd(DB::getQueryLog());
}

function cLng($key = null) {
    $lngManager = new LngManager();
    $language = $lngManager->getCurrentLanguage();
    if ($language == null) {
        return null;
    }
    if ($key) {
        return $language->$key;
    }
    return $language;
}

function url_with_lng($path, $slash = true) {
    return url(cLng('code') . '/' . ltrim($path, '/')) . ($slash ? '/' : '');
}