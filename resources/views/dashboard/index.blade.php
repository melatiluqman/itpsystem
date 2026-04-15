@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="topbar">
    <div>
        <h1>Dashboard Modul</h1>
        <div class="breadcrumb">Pilih modul untuk memulai inspeksi</div>
    </div>
</div>

@if(!$projectStarted)
<div class="card" style="border-color: rgba(245, 158, 11, 0.3);">
    <div class="empty-state">
        <i class="fas fa-exclamation-triangle" style="color: var(--accent-orange);"></i>
        <h3 style="margin-bottom: 8px; font-size: 18px;">Project Belum Dimulai</h3>
        <p>Hubungi admin untuk memulai project terlebih dahulu.</p>
    </div>
</div>
@else
<div class="card-grid">
    @foreach($moduls as $modul)
    <a href="{{ route('blok.index', $modul->id_modul) }}" class="card" style="text-decoration: none; cursor: pointer;">
        <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 16px;">
            <div class="stat-icon" style="background: linear-gradient(135deg, rgba(59, 130, 246, 0.2), rgba(6, 182, 212, 0.1)); color: var(--accent-cyan); min-width: 48px;">
                <i class="fas fa-cube"></i>
            </div>
            <div>
                <h3 style="font-size: 18px; font-weight: 700; color: var(--text-primary);">{{ $modul->nama_modul }}</h3>
                <p style="font-size: 13px; color: var(--text-muted); margin-top: 2px;">{{ $modul->deskripsi }}</p>
            </div>
        </div>
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <span class="badge badge-cyan">{{ $modul->bloks->count() }} Block</span>
            <i class="fas fa-chevron-right" style="color: var(--text-muted); font-size: 12px;"></i>
        </div>
    </a>
    @endforeach
</div>
@endif
@endsection
