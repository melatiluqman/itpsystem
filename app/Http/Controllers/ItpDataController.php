<?php

namespace App\Http\Controllers;

use App\Models\ItpData;
use App\Models\RoleCodeAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItpDataController extends Controller
{
    public function show($id)
    {
        $itpData = ItpData::with(['kode', 'assemblyCode'])->findOrFail($id);
        return response()->json($itpData);
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();

        $itpData = ItpData::findOrFail($id);

        // Check assignment mark for this user's role
        $assignment = RoleCodeAssignment::where('id_role', $user->id_role)
            ->where('kode', $itpData->kode)
            ->where('work_context', $request->input('work_context', 'WORKSHOP'))
            ->first();

        if (!$assignment || !in_array($assignment->assignment_mark, ['W', 'RV'])) {
            return response()->json(['error' => 'Tidak punya akses.'], 403);
        }

        $rules = [
            'note' => 'nullable|string',
            'status_itp_data' => 'required|in:pending,on progress,approve,rejected',
        ];

        // W = wajib upload foto
        if ($assignment->assignment_mark === 'W') {
            if (!$itpData->foto && !$request->hasFile('foto')) {
                $rules['foto'] = 'required|image|max:5120';
            } else {
                $rules['foto'] = 'nullable|image|max:5120';
            }
        } else {
            $rules['foto'] = 'nullable|image|max:5120';
        }

        $request->validate($rules);

        if ($request->hasFile('foto')) {
            // Delete old photo if exists
            if ($itpData->foto && Storage::disk('public')->exists('itp-photos/' . $itpData->foto)) {
                Storage::disk('public')->delete('itp-photos/' . $itpData->foto);
            }

            $file = $request->file('foto');
            $filename = time() . '_' . $itpData->assembly_code . '_' . str_replace('.', '-', $itpData->kode) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('itp-photos', $filename, 'public');
            $itpData->foto = $filename;
        }

        $itpData->note = $request->input('note', $itpData->note);
        $itpData->status_itp_data = $request->input('status_itp_data');
        $itpData->tanggal_inspeksi = now();
        $itpData->save();

        return response()->json([
            'success' => true,
            'message' => 'ITP Data berhasil diperbarui.',
            'data' => $itpData
        ]);
    }
}
