<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blok extends Model
{
    protected $table = 'blok';
    protected $primaryKey = 'id_blok';
    public $timestamps = false;

    protected $fillable = ['id_modul', 'nama_blok'];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = null;

    public function modul()
    {
        return $this->belongsTo(Modul::class, 'id_modul', 'id_modul');
    }

    public function subbloks()
    {
        return $this->hasMany(SubBlok::class, 'id_blok', 'id_blok');
    }
}
