<?php

namespace App\Http\Controllers;

use App\Models\Modul;
use App\Models\ItpData;

class ModulController extends Controller
{
    public function index()
    {
        $projectStarted = ItpData::count() > 0;
        $moduls = Modul::all();

        return view('dashboard.index', compact('moduls', 'projectStarted'));
    }
}
