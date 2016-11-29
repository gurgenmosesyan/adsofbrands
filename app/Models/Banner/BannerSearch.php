<?php

namespace App\Models\Banner;

use App\Core\DataTable;

class BannerSearch extends DataTable
{
    public function totalCount()
    {
        return Banner::count();
    }

    public function filteredCount()
    {
        $query = $this->constructQuery();
        $this->constructOrder($query);
        return $query->count();
    }

    public function search()
    {
        $query = $this->constructQuery();
        $data = $query->get();
        foreach ($data as $value) {
            $value->key = trans('admin.banner.key.'.$value->key);
        }
        return $data;
    }

    protected function constructQuery()
    {
        return Banner::select('banners.id', 'banners.key', 'banners.type', 'admin1.email as created_by', 'admin2.email as updated_by')
            ->leftJoin('adm_users as admin1', function($query) {
                $query->on('admin1.id', '=', 'banners.add_admin_id');
            })
            ->leftJoin('adm_users as admin2', function($query) {
                $query->on('admin2.id', '=', 'banners.update_admin_id');
            });
    }

    protected function constructOrder($query)
    {
        switch ($this->orderCol) {
            case 'key':
                $orderCol = 'key';
                break;
            case 'type':
                $orderCol = 'type';
                break;
            default:
                $orderCol = 'id';
        }
        $orderType = 'desc';
        if ($this->orderType == 'asc') {
            $orderType = 'asc';
        }
        $query->orderBy($orderCol, $orderType);
    }
}