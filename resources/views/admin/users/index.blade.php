@extends('layouts.app')
@section('title', 'Kelola User')

@section('content')
<div class="topbar">
    <div>
        <h1>Kelola User</h1>
        <div class="breadcrumb"><a href="/admin/dashboard">Dashboard</a> / Users</div>
    </div>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah User
    </a>
</div>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Username</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $i => $user)
            <tr>
                <td style="color: var(--text-muted);">{{ $i + 1 }}</td>
                <td style="font-weight: 600;">{{ $user->nama }}</td>
                <td style="color: var(--text-secondary);">{{ $user->username }}</td>
                <td>
                    @php
                        $roleBadge = match($user->role->nama_role ?? '') {
                            'admin' => 'badge-purple',
                            'yard' => 'badge-blue',
                            'class' => 'badge-green',
                            'OS' => 'badge-orange',
                            'stat' => 'badge-cyan',
                            default => 'badge-blue',
                        };
                    @endphp
                    <span class="badge {{ $roleBadge }}">{{ $user->role->nama_role ?? '-' }}</span>
                </td>
                <td>
                    <div style="display: flex; gap: 6px;">
                        <a href="{{ route('admin.users.edit', $user->id_user) }}" class="btn btn-outline btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        @if($user->id_user != auth()->id())
                        <form action="{{ route('admin.users.destroy', $user->id_user) }}" method="POST"
                              onsubmit="return confirm('Hapus user {{ $user->nama }}?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
