<?php

namespace App\Core\Admin;

class Manager
{
    public function store($data)
    {
        $data = $this->processSave($data);
        $admin = new Admin($data);
        $admin->password = bcrypt($data['password']);
        return $admin->save();
    }

    public function update($id, $data)
    {
        $admin = Admin::findOrFail($id);
        $data = $this->processSave($data);
        if (!empty($data['password'])) {
            $admin->password = bcrypt($data['password']);
        }
        return $admin->update($data);
    }

    protected function processSave($data)
    {
        $data['super_admin'] = isset($data['super_admin']) ? $data['super_admin'] : Admin::NOT_SUPER_ADMIN;

        if ($data['super_admin'] == Admin::SUPER_ADMIN) {
            $data['permissions'] = '';
        } else {
            if (!isset($data['permissions'])) {
                $data['permissions'] = [];
            }
            $data['permissions'] = json_encode($data['permissions']);
        }

        return $data;
    }

    public function delete($id)
    {
        Admin::where('id', $id)->delete();
        return true;
    }
}