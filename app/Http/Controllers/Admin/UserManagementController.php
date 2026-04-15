<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::with('role')->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:user,username',
            'password' => 'required|string|min:6',
            'id_role' => 'required|exists:role,id_role',
        ]);

        User::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => hash('sha256', $request->password),
            'id_role' => $request->id_role,
        ]);

        return redirect('/admin/users')->with('success', 'User berhasil dibuat.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:user,username,' . $id . ',id_user',
            'id_role' => 'required|exists:role,id_role',
        ]);

        $data = [
            'nama' => $request->nama,
            'username' => $request->username,
            'id_role' => $request->id_role,
        ];

        if ($request->filled('password')) {
            $data['password'] = hash('sha256', $request->password);
        }

        $user->update($data);

        return redirect('/admin/users')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->id_user == auth()->id()) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri.');
        }

        $user->delete();

        return redirect('/admin/users')->with('success', 'User berhasil dihapus.');
    }
}
