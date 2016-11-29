<?php

namespace App\Core\Admin;

use App\Core\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class Admin extends Model implements AuthenticatableContract
{
    use Authenticatable;

    const SUPER_ADMIN = '1';
    const NOT_SUPER_ADMIN = '0';

    protected $guard = 'admin';

    protected $table = 'adm_users';

    protected $fillable = [
        'email',
        'lng_id',
        'super_admin',
        'permissions',
        'homepage'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    public function isSuperAdmin()
    {
        return $this->super_admin == self::SUPER_ADMIN;
    }

    public function getPermissionsAttribute($value)
    {
        return json_decode($value, true);
    }
}