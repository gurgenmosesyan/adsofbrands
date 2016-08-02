<?php

namespace App\Core\Helpers;


class JsTrans
{
    private $data;

    public function addTrans($keys)
    {
        foreach ($keys as $key) {
            $this->data[$key] = trans($key);
        }
    }

    public function getTrans()
    {
        return $this->data;
    }
}