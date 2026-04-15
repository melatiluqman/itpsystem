@extends('layouts.app')
@section('title', 'Admin Dashboard')

@section('content')
<div class="topbar">
    <div>
        <h1>Admin Dashboard</h1>
        <div class="breadcrumb">Selamat datang, {{ auth()->user()->nama }}</div>
    </div>
</div>

<!-- Stats -->
<div class="card-grid" style="margin-bottom: 28px;">
    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(59, 130, 246, 0.15); color: var(--accent-blue);">
            <i class="fas fa-users"></i>
        </div>
        <div>
            <div class="stat-value">{{ $totalUsers }}</div>
            <div class="stat-label">Total Users</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(6, 182, 212, 0.15); color: var(--accent-cyan);">
            <i class="fas fa-cubes"></i>
        </div>
        <div>
            <div class="stat-value">{{ $totalModuls }}</div>
            <div class="stat-label">Total Modul</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: {{ $projectStarted ? 'rgba(16, 185, 129, 0.15)' : 'rgba(245, 158, 11, 0.15)' }}; color: {{ $projectStarted ? 'var(--accent-green)' : 'var(--accent-orange)' }};">
            <i class="fas {{ $projectStarted ? 'fa-check-circle' : 'fa-clock' }}"></i>
        </div>
        <div>
            <div class="stat-value">{{ $projectStarted ? 'Active' : 'Idle' }}</div>
            <div class="stat-label">Project Status</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(139, 92, 246, 0.15); color: var(--accent-purple);">
            <i class="fas fa-clipboard-list"></i>
        </div>
        <div>
            <div class="stat-value">{{ $totalItpData }}</div>
            <div class="stat-label">ITP Records</div>
        </div>
    </div>
</div>

<!-- Project Start -->
@if(!$projectStarted)
<div class="card" style="margin-bottom: 28px; border-color: rgba(245, 158, 11, 0.3);">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
        <div>
            <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 4px;">
                <i class="fas fa-rocket" style="color: var(--accent-orange); margin-right: 8px;"></i>
                Start Project
            </h3>
            <p style="font-size: 13px; color: var(--text-muted);">
                Klik tombol untuk memulai project dan generate semua ITP data records.
            </p>
        </div>
        <form action="{{ route('admin.project.start') }}" method="POST" onsubmit="return confirm('Yakin ingin memulai project? Ini akan generate semua ITP data records.')">
            @csrf
            <button type="submit" class="btn btn-warning">
                <i class="fas fa-play"></i> Mulai Project
            </button>
        </form>
    </div>
</div>
@else
<!-- Status Breakdown -->
<div class="card" style="margin-bottom: 28px;">
    <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 16px;">
        <i class="fas fa-chart-bar" style="color: var(--accent-cyan); margin-right: 8px;"></i>
        Status ITP Data
    </h3>
    <div class="card-grid">
        <div style="display: flex; align-items: center; gap: 12px;">
            <div class="badge status-pending" style="font-size: 22px; font-weight: 800; padding: 10px 16px;">
                {{ $statusCounts['pending'] ?? 0 }}
            </div>
            <span style="font-size: 13px; color: var(--text-secondary);">Pending</span>
        </div>
        <div style="display: flex; align-items: center; gap: 12px;">
            <div class="badge status-progress" style="font-size: 22px; font-weight: 800; padding: 10px 16px;">
                {{ $statusCounts['on progress'] ?? 0 }}
            </div>
            <span style="font-size: 13px; color: var(--text-secondary);">On Progress</span>
        </div>
        <div style="display: flex; align-items: center; gap: 12px;">
            <div class="badge status-approve" style="font-size: 22px; font-weight: 800; padding: 10px 16px;">
                {{ $statusCounts['approve'] ?? 0 }}
            </div>
            <span style="font-size: 13px; color: var(--text-secondary);">Approved</span>
        </div>
        <div style="display: flex; align-items: center; gap: 12px;">
            <div class="badge status-rejected" style="font-size: 22px; font-weight: 800; padding: 10px 16px;">
                {{ $statusCounts['rejected'] ?? 0 }}
            </div>
            <span style="font-size: 13px; color: var(--text-secondary);">Rejected</span>
        </div>
    </div>
</div>
@endif

<!-- Recent Users Table -->
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
        <h3 style="font-size: 16px; font-weight: 700;">
            <i class="fas fa-users" style="color: var(--accent-blue); margin-right: 8px;"></i>
            Daftar User
        </h3>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah User
        </a>
    </div>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
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
                                <i class="fas fa-edit"></i>
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
</div>
@endsection
