<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssemblyCode extends Model
{
    protected $table = 'assembly_code';
    protected $primaryKey = 'assembly_code';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = ['assembly_code', 'id_subblok', 'keterangan'];

    public function subblok()
    {
        return $this->belongsTo(SubBlok::class, 'id_subblok', 'id_subblok');
    }

    public function kodes()
    {
        return $this->belongsToMany(Kode::class, 'kode_assembly_code', 'assembly_code', 'kode', 'assembly_code', 'kode');
    }

    public function itpData()
    {
        return $this->hasMany(ItpData::class, 'assembly_code', 'assembly_code');
    }
}
