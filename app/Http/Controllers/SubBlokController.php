<?php

namespace App\Http\Controllers;

use App\Models\Blok;
use App\Models\SubBlok;
use App\Models\ItpData;

class SubBlokController extends Controller
{
    public function index($id)
    {
        $projectStarted = ItpData::count() > 0;
        if (!$projectStarted) {
            return redirect('/dashboard')->with('error', 'Project belum dimulai.');
        }

        $blok = Blok::with('modul')->findOrFail($id);
        $subbloks = SubBlok::where('id_blok', $id)->get();

        return view('dashboard.subblok', compact('blok', 'subbloks'));
    }
}
