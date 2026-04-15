<?php

namespace App\Http\Controllers;

use App\Models\Modul;
use App\Models\Blok;
use App\Models\ItpData;

class BlokController extends Controller
{
    public function index($id)
    {
        $projectStarted = ItpData::count() > 0;
        if (!$projectStarted) {
            return redirect('/dashboard')->with('error', 'Project belum dimulai.');
        }

        $modul = Modul::findOrFail($id);
        $bloks = Blok::where('id_modul', $id)->get();

        return view('dashboard.blok', compact('modul', 'bloks'));
    }
}
