<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'role';
    protected $primaryKey = 'id_role';
    public $timestamps = false;

    protected $fillable = ['nama_role'];

    public function users()
    {
        return $this->hasMany(User::class, 'id_role', 'id_role');
    }

    public function roleCodeAssignments()
    {
        return $this->hasMany(RoleCodeAssignment::class, 'id_role', 'id_role');
    }
}
