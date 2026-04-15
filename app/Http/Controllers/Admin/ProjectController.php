<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ItpData;
use App\Models\KodeAssemblyCode;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function start()
    {
        if (ItpData::count() > 0) {
            return back()->with('error', 'Project sudah dimulai sebelumnya.');
        }

        $kodeAssemblyCodes = KodeAssemblyCode::all();

        $itpDataRecords = [];
        $now = now();

        foreach ($kodeAssemblyCodes as $kac) {
            $itpDataRecords[] = [
                'kode' => $kac->kode,
                'assembly_code' => $kac->assembly_code,
                'status_itp_data' => 'pending',
                'foto' => null,
                'note' => '',
                'tanggal_inspeksi' => $now,
            ];
        }

        foreach (array_chunk($itpDataRecords, 100) as $chunk) {
            ItpData::insert($chunk);
        }

        return back()->with('success', 'Project berhasil dimulai! ' . count($itpDataRecords) . ' ITP data records dibuat.');
    }
}
