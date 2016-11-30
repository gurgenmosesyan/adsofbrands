<?php

namespace App\Models\FooterMenu;

use App\Core\DataTable;

class FooterMenuSearch extends DataTable
{
    public function totalCount()
    {
        return FooterMenu::count();
    }

    public function filteredCount()
    {
        $query = $this->constructQuery();
        return $query->count();
    }

    public function search()
    {
        $query = $this->constructQuery();
        $this->constructOrder($query);
        $this->constructLimit($query);
        $data = $query->get();
        foreach ($data as $value) {
            $value->show_status = $value->show_status == FooterMenu::STATUS_ACTIVE ? '<i class="fa fa-check"></i>' : '';
            $value->preview = '<a href="'.url_with_lng('/page/'.$value->alias.'?hash='.$value->hash).'" target="_blank">'.trans('admin.base.label.preview').'</a>';
        }
        return $data;
    }

    protected function constructQuery()
    {
        $query = FooterMenu::select('footer_menu.id', 'ml.title', 'footer_menu.alias', 'footer_menu.show_status', 'footer_menu.hash', 'admin1.email as created_by', 'admin2.email as updated_by')
            ->joinMl()
            ->leftJoin('adm_users as admin1', function($query) {
                $query->on('admin1.id', '=', 'footer_menu.add_admin_id');
            })
            ->leftJoin('adm_users as admin2', function($query) {
                $query->on('admin2.id', '=', 'footer_menu.update_admin_id');
            });

        if ($this->search != null) {
            $query->where('ml.title', 'LIKE', '%'.$this->search.'%')
                ->orWhere('ml.text', 'LIKE', '%'.$this->search.'%');
        }
        return $query;
    }

    protected function constructOrder($query)
    {
        switch ($this->orderCol) {
            case 'title':
                $orderCol = 'ml.title';
                break;
            case 'show_status':
                $orderCol = 'footer_menu.show_status';
                break;
            default:
                $orderCol = 'footer_menu.id';
        }
        $orderType = 'desc';
        if ($this->orderType == 'asc') {
            $orderType = 'asc';
        }
        $query->orderBy($orderCol, $orderType);
    }

    protected function constructLimit($query)
    {
        $query->skip($this->start)->take($this->length);
    }
}