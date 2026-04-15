@extends('layouts.app')
@section('title', 'Tambah User')

@section('content')
<div class="topbar">
    <div>
        <h1>Tambah User Baru</h1>
        <div class="breadcrumb">
            <a href="/admin/dashboard">Dashboard</a> / <a href="/admin/users">Users</a> / Tambah
        </div>
    </div>
</div>

<div class="card" style="max-width: 540px;">
    <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf
        <div class="form-group">
            <label for="nama">Nama Lengkap</label>
            <input type="text" id="nama" name="nama" class="form-control" value="{{ old('nama') }}" required>
            @error('nama') <div class="form-error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" class="form-control" value="{{ old('username') }}" required>
            @error('username') <div class="form-error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" class="form-control" required>
            @error('password') <div class="form-error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="id_role">Role</label>
            <select id="id_role" name="id_role" class="form-control" required>
                <option value="">Pilih Role</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id_role }}" {{ old('id_role') == $role->id_role ? 'selected' : '' }}>
                        {{ ucfirst($role->nama_role) }}
                    </option>
                @endforeach
            </select>
            @error('id_role') <div class="form-error">{{ $message }}</div> @enderror
        </div>

        <div style="display: flex; gap: 10px; margin-top: 24px;">
            <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
            <a href="/admin/users" class="btn btn-outline">Batal</a>
        </div>
    </form>
</div>
@endsection
