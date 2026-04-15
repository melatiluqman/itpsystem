<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItpData extends Model
{
    protected $table = 'itp_data';
    protected $primaryKey = 'id_itp_data';
    public $timestamps = false;

    protected $fillable = [
        'kode',
        'status_itp_data',
        'foto',
        'note',
        'tanggal_inspeksi',
        'assembly_code',
    ];

    public function kode()
    {
        return $this->belongsTo(Kode::class, 'kode', 'kode');
    }

    public function assemblyCode()
    {
        return $this->belongsTo(AssemblyCode::class, 'assembly_code', 'assembly_code');
    }
}
