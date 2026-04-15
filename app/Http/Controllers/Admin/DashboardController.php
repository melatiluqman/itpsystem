<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Modul;
use App\Models\ItpData;
use App\Models\KodeAssemblyCode;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalModuls = Modul::count();
        $projectStarted = ItpData::count() > 0;
        $totalItpData = ItpData::count();

        $statusCounts = [];
        if ($projectStarted) {
            $statusCounts = ItpData::selectRaw('status_itp_data, COUNT(*) as count')
                ->groupBy('status_itp_data')
                ->pluck('count', 'status_itp_data')
                ->toArray();
        }

        $users = User::with('role')->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalModuls',
            'projectStarted',
            'totalItpData',
            'statusCounts',
            'users'
        ));
    }
}
