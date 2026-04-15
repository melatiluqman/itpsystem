<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kode extends Model
{
    protected $table = 'kode';
    protected $primaryKey = 'kode';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = ['kode', 'deskripsi_kode'];

    public function assemblyCodes()
    {
        return $this->belongsToMany(AssemblyCode::class, 'kode_assembly_code', 'kode', 'assembly_code', 'kode', 'assembly_code');
    }

    public function itpData()
    {
        return $this->hasMany(ItpData::class, 'kode', 'kode');
    }

    public function roleCodeAssignments()
    {
        return $this->hasMany(RoleCodeAssignment::class, 'kode', 'kode');
    }
}
