<?php

namespace App\Http\Controllers;

use App\Models\SubBlok;
use App\Models\AssemblyCode;
use App\Models\RoleCodeAssignment;
use App\Models\ItpData;
use App\Models\KodeAssemblyCode;
use Illuminate\Http\Request;

class AssemblyCodeController extends Controller
{
    public function index(Request $request, $id)
    {
        $projectStarted = ItpData::count() > 0;
        if (!$projectStarted) {
            return redirect('/dashboard')->with('error', 'Project belum dimulai.');
        }

        $subblok = SubBlok::with('blok.modul')->findOrFail($id);
        $assemblyCodes = AssemblyCode::where('id_subblok', $id)->get();

        $workContext = $request->get('context', 'WORKSHOP');
        $user = auth()->user();
        $roleId = $user->id_role;

        // Get role assignments for current user and context
        $assignments = RoleCodeAssignment::where('id_role', $roleId)
            ->where('work_context', $workContext)
            ->whereIn('assignment_mark', ['W', 'RV'])
            ->pluck('assignment_mark', 'kode')
            ->toArray();

        // Build inspection data per assembly code
        $assemblyInspections = [];
        foreach ($assemblyCodes as $ac) {
            $kodeAssemblies = KodeAssemblyCode::where('assembly_code', $ac->assembly_code)
                ->whereIn('kode', array_keys($assignments))
                ->get();

            $inspections = [];
            foreach ($kodeAssemblies as $ka) {
                $itpData = ItpData::where('assembly_code', $ac->assembly_code)
                    ->where('kode', $ka->kode)
                    ->first();

                $kodeModel = $ka->kodeModel;

                $inspections[] = [
                    'kode' => $ka->kode,
                    'deskripsi' => $kodeModel ? $kodeModel->deskripsi_kode : '',
                    'mark' => $assignments[$ka->kode] ?? '-',
                    'itp_data' => $itpData,
                ];
            }

            if (count($inspections) > 0) {
                $assemblyInspections[] = [
                    'assembly_code' => $ac->assembly_code,
                    'keterangan' => $ac->keterangan,
                    'inspections' => $inspections,
                ];
            }
        }

        return view('dashboard.assembly', compact(
            'subblok',
            'assemblyInspections',
            'workContext'
        ));
    }
}
