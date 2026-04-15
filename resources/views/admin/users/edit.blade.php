@extends('layouts.app')
@section('title', 'Edit User')

@section('content')
<div class="topbar">
    <div>
        <h1>Edit User</h1>
        <div class="breadcrumb">
            <a href="/admin/dashboard">Dashboard</a> / <a href="/admin/users">Users</a> / Edit
        </div>
    </div>
</div>

<div class="card" style="max-width: 540px;">
    <form method="POST" action="{{ route('admin.users.update', $user->id_user) }}">
        @csrf @method('PUT')
        <div class="form-group">
            <label for="nama">Nama Lengkap</label>
            <input type="text" id="nama" name="nama" class="form-control" value="{{ old('nama', $user->nama) }}" required>
            @error('nama') <div class="form-error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" class="form-control" value="{{ old('username', $user->username) }}" required>
            @error('username') <div class="form-error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="password">Password <span style="color: var(--text-muted); font-weight: 400;">(kosongkan jika tidak diubah)</span></label>
            <input type="password" id="password" name="password" class="form-control">
            @error('password') <div class="form-error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="id_role">Role</label>
            <select id="id_role" name="id_role" class="form-control" required>
                @foreach($roles as $role)
                    <option value="{{ $role->id_role }}" {{ old('id_role', $user->id_role) == $role->id_role ? 'selected' : '' }}>
                        {{ ucfirst($role->nama_role) }}
                    </option>
                @endforeach
            </select>
            @error('id_role') <div class="form-error">{{ $message }}</div> @enderror
        </div>

        <div style="display: flex; gap: 10px; margin-top: 24px;">
            <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Update</button>
            <a href="/admin/users" class="btn btn-outline">Batal</a>
        </div>
    </form>
</div>
@endsection
