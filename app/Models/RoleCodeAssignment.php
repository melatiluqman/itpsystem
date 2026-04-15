<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleCodeAssignment extends Model
{
    protected $table = 'role_code_assignment';
    protected $primaryKey = 'id_role_code_assignment';
    public $timestamps = false;

    protected $fillable = ['id_role', 'kode', 'work_context', 'assignment_mark'];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = null;

    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role', 'id_role');
    }

    public function kodeModel()
    {
        return $this->belongsTo(Kode::class, 'kode', 'kode');
    }
}
