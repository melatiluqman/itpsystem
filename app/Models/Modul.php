<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modul extends Model
{
    protected $table = 'modul';
    protected $primaryKey = 'id_modul';
    public $timestamps = false;

    protected $fillable = ['nama_modul', 'deskripsi'];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = null;

    public function bloks()
    {
        return $this->hasMany(Blok::class, 'id_modul', 'id_modul');
    }
}
