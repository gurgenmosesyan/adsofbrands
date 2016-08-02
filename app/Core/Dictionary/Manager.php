<?php

namespace App\Core\Dictionary;

use App\Core\Language\Language;

class Manager
{
    public function dictionaryData($appId)
    {
        $data = [];
        $fileName = $appId == '2' ? '/www.php' : '/admin.php';
        $languages = Language::all()->keyBy('id');
        foreach ($languages as $lng) {
            $filePath = resource_path('lang/'.$lng->code.$fileName);
            if (file_exists($filePath)) {
                $messages = include $filePath;
                if (is_array($messages)) {
                    foreach ($messages as $key => $value) {
                        if (!isset($data[$key])) {
                            $data[$key] = [];
                            $data[$key]['key'] = $key;
                        }
                        $data[$key][$lng->code] = $value;
                    }
                }
            }
        }
        $data = array_values($data);
        foreach ($data as $key => $value) {
            foreach ($languages as $lng) {
                if (!isset($value[$lng->code])) {
                    $data[$key][$lng->code] = '';
                }
            }
        }
        return $data;
    }

    public function update($data)
    {
        $fileName = $data['app'] == '2' ? '/www.php' : '/admin.php';
        $languages = Language::all()->keyBy('id');
        foreach ($languages as $lng) {
            $dirPath = resource_path('lang/'.$lng->code);
            if (!file_exists($dirPath)) {
                mkdir($dirPath, 0777, true);
            }
            $filePath = $dirPath.$fileName;
            if (!file_exists($filePath)) {
                $f = fopen($filePath, 'w');
                fclose($f);
            }
            $messages = include $filePath;
            if (!is_array($messages)) {
                $messages = [];
            }
            $value = isset($data['ml'][$lng->code]) ? $data['ml'][$lng->code] : '';
            if (isset($messages[$data['origin_key']])) {
                if ($data['origin_key'] == $data['key']) {
                    $messages[$data['origin_key']] = $value;
                } else {
                    $messages[$data['key']] = $value;
                    unset($messages[$data['origin_key']]);
                }
            } else {
                $messages[$data['key']] = $value;
            }
            $this->saveFile($filePath, $messages);
        }
        return true;
    }

    public function delete($key, $appId)
    {
        $fileName = $appId == '2' ? '/www.php' : '/admin.php';
        $languages = Language::all()->keyBy('id');
        foreach ($languages as $lng) {
            $filePath = resource_path('lang/'.$lng->code.$fileName);
            if (file_exists($filePath)) {
                $messages = include $filePath;
                if (isset($messages[$key])) {
                    unset($messages[$key]);
                }
                $this->saveFile($filePath, $messages);
            }
        }
        return true;
    }

    protected function saveFile($filePath, $messages)
    {
        $messages = var_export($messages, true);
        file_put_contents($filePath, "<?php\n\nreturn {$messages};");
    }
}