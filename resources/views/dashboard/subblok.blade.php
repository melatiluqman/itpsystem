@extends('layouts.app')
@section('title', 'Sub-Blok - ' . $blok->nama_blok)

@section('content')
<div class="topbar">
    <div>
        <h1>{{ $blok->nama_blok }}</h1>
        <div class="breadcrumb">
            <a href="/dashboard">Dashboard</a> /
            <a href="{{ route('blok.index', $blok->modul->id_modul) }}">{{ $blok->modul->nama_modul }}</a> /
            {{ $blok->nama_blok }} / Sub-Blok
        </div>
    </div>
    <a href="{{ route('blok.index', $blok->modul->id_modul) }}" class="btn btn-outline btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>

@if($subbloks->isEmpty())
<div class="card">
    <div class="empty-state">
        <i class="fas fa-box-open"></i>
        <p>Belum ada sub-blok di blok ini.</p>
    </div>
</div>
@else
<div class="card-grid">
    @foreach($subbloks as $subblok)
    <a href="{{ route('assembly.index', $subblok->id_subblok) }}" class="card" style="text-decoration: none; cursor: pointer;">
        <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 16px;">
            <div class="stat-icon" style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.2), rgba(6, 182, 212, 0.1)); color: var(--accent-green); min-width: 48px;">
                <i class="fas fa-puzzle-piece"></i>
            </div>
            <div>
                <h3 style="font-size: 16px; font-weight: 700; color: var(--text-primary);">{{ $subblok->nama_subblok }}</h3>
                <p style="font-size: 12px; color: var(--text-muted); margin-top: 2px;">{{ $blok->nama_blok }}</p>
            </div>
        </div>
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <span class="badge badge-green">{{ $subblok->assemblyCodes->count() }} Assembly</span>
            <i class="fas fa-chevron-right" style="color: var(--text-muted); font-size: 12px;"></i>
        </div>
    </a>
    @endforeach
</div>
@endif
@endsection
