<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KodeAssemblyCode extends Model
{
    protected $table = 'kode_assembly_code';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = ['kode', 'assembly_code'];

    public function kodeModel()
    {
        return $this->belongsTo(Kode::class, 'kode', 'kode');
    }

    public function assemblyCodeModel()
    {
        return $this->belongsTo(AssemblyCode::class, 'assembly_code', 'assembly_code');
    }
}
