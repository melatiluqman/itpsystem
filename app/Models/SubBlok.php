<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubBlok extends Model
{
    protected $table = 'subblok';
    protected $primaryKey = 'id_subblok';
    public $timestamps = false;

    protected $fillable = ['id_blok', 'nama_subblok'];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = null;

    public function blok()
    {
        return $this->belongsTo(Blok::class, 'id_blok', 'id_blok');
    }

    public function assemblyCodes()
    {
        return $this->hasMany(AssemblyCode::class, 'id_subblok', 'id_subblok');
    }
}
