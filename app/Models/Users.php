<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Users extends Authenticatable
{
    protected $primaryKey = 'username';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'username',
        'nama_lengkap',
        'kelas',
        'password',
    ];

    protected $hidden = [
        'password'
    ];

    public function getRouteKeyName()
    {
        return 'username';
    }

    public function userType()
    {
    return $this->hasOne(UsersType::class, 'username', 'username');
    }
}
