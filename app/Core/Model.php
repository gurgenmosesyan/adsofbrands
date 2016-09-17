<?php

namespace App\Core;

use Illuminate\Database\Eloquent\Model as EloquentModel;

class Model extends EloquentModel
{
    const STATUS_ACTIVE = '1';
    const STATUS_INACTIVE = '2';
    const STATUS_DELETED = '0';

    public function scopeJoinMl($query)
    {
        $table = $this->getTable();
        return $query->join($table.'_ml as ml', function($query) use($table) {
            $query->on('ml.id', '=', $table.'.id')->where('ml.lng_id', '=', cLng('id'));
        });
    }

    public function scopeLeftJoinMl($query)
    {
        $table = $this->getTable();
        return $query->leftJoin($table.'_ml as ml', function($query) use($table) {
            $query->on('ml.id', '=', $table.'.id')->where('ml.lng_id', '=', cLng('id'));
        });
    }

    public function scopeActive($query)
    {
        return $query->where($this->getTable().'.show_status', self::STATUS_ACTIVE);
    }

    public function scopeCurrent($query)
    {
        return $query->where($this->getTable().'.lng_id', cLng('id'));
    }

    public function scopeOrdered($query)
    {
        $table = $this->getTable();
        return $query->orderBy($table.'.sort_order', 'asc')->orderBy($table.'.id', 'desc');
    }

    public function scopeLatest($query)
    {
        return $query->orderBy($this->getTable().'.id', 'desc');
    }
}