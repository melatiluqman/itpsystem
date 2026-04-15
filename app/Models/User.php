<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'user';
    protected $primaryKey = 'id_user';
    public $timestamps = false;

    protected $fillable = ['id_role', 'nama', 'username', 'password'];

    protected $hidden = ['password'];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = null;

    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role', 'id_role');
    }

    public function isAdmin()
    {
        return $this->id_role == 5;
    }

    public function isYard()
    {
        return $this->id_role == 1;
    }

    public function getRoleName()
    {
        return $this->role->nama_role ?? 'unknown';
    }
}
