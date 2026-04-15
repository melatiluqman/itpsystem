@extends('layouts.app')
@section('title', 'Blok - ' . $modul->nama_modul)

@section('content')
<div class="topbar">
    <div>
        <h1>{{ $modul->nama_modul }}</h1>
        <div class="breadcrumb">
            <a href="/dashboard">Dashboard</a> / {{ $modul->nama_modul }} / Blok
        </div>
    </div>
    <a href="/dashboard" class="btn btn-outline btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>

@if($bloks->isEmpty())
<div class="card">
    <div class="empty-state">
        <i class="fas fa-box-open"></i>
        <p>Belum ada blok di modul ini.</p>
    </div>
</div>
@else
<div class="card-grid">
    @foreach($bloks as $blok)
    <a href="{{ route('subblok.index', $blok->id_blok) }}" class="card" style="text-decoration: none; cursor: pointer;">
        <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 16px;">
            <div class="stat-icon" style="background: linear-gradient(135deg, rgba(139, 92, 246, 0.2), rgba(59, 130, 246, 0.1)); color: var(--accent-purple); min-width: 48px;">
                <i class="fas fa-layer-group"></i>
            </div>
            <div>
                <h3 style="font-size: 18px; font-weight: 700; color: var(--text-primary);">{{ $blok->nama_blok }}</h3>
                <p style="font-size: 13px; color: var(--text-muted); margin-top: 2px;">{{ $modul->nama_modul }}</p>
            </div>
        </div>
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <span class="badge badge-purple">{{ $blok->subbloks->count() }} Sub-Blok</span>
            <i class="fas fa-chevron-right" style="color: var(--text-muted); font-size: 12px;"></i>
        </div>
    </a>
    @endforeach
</div>
@endif
@endsection
