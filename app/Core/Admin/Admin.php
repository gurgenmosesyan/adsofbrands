<?php

namespace App\Core\Admin;

use App\Core\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class Admin extends Model implements AuthenticatableContract
{
    use Authenticatable;

    protected $guard = 'admin';

    protected $table = 'adm_users';

    protected $fillable = [
        'email',
        'lng_id'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];
}