@extends('layouts.app')

@section('content')
<div class="mb-4">
    <h4 class="mb-1">Selamat datang, {{ auth()->user()->name }} 👋</h4>
    <small class="text-muted">
        Role: <span class="badge {{ auth()->user()->isAdmin() ? 'bg-danger' : 'bg-secondary' }}">
            {{ ucfirst(auth()->user()->role) }}
        </span>
    </small>
</div>

<div class="row g-4 mb-4">
    <div class="col-sm-4">
        <div class="card border-0 shadow-sm text-center p-4">
            <div class="fs-1 text-primary mb-2"><i class="bi bi-people-fill"></i></div>
            <div class="fs-2 fw-bold">{{ $totalKaryawan }}</div>
            <div class="text-muted">Total Karyawan</div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card border-0 shadow-sm text-center p-4">
            <div class="fs-1 text-success mb-2"><i class="bi bi-briefcase-fill"></i></div>
            <div class="fs-2 fw-bold">{{ $totalJabatan }}</div>
            <div class="text-muted">Total Jabatan</div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card border-0 shadow-sm text-center p-4">
            <div class="fs-1 text-warning mb-2"><i class="bi bi-building"></i></div>
            <div class="fs-2 fw-bold">{{ $totalDepartemen }}</div>
            <div class="text-muted">Total Departemen</div>
        </div>
    </div>
</div>

@if(auth()->user()->isAdmin())
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white fw-semibold border-bottom">
        <i class="bi bi-grid me-2 text-primary"></i>Menu Admin
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-6 col-md-3">
                <a href="{{ route('karyawan.index') }}" class="btn btn-outline-primary w-100 py-3">
                    <i class="bi bi-person-badge d-block fs-4 mb-1"></i>Karyawan
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="{{ route('jabatan.index') }}" class="btn btn-outline-success w-100 py-3">
                    <i class="bi bi-briefcase d-block fs-4 mb-1"></i>Jabatan
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="{{ route('departemen.index') }}" class="btn btn-outline-warning w-100 py-3">
                    <i class="bi bi-building d-block fs-4 mb-1"></i>Departemen
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="{{ route('kategori.index') }}" class="btn btn-outline-secondary w-100 py-3">
                    <i class="bi bi-receipt d-block fs-4 mb-1"></i>Hasil Penggajian
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="{{ route('penggajian.rekap') }}" class="btn btn-outline-danger w-100 py-3">
                    <i class="bi bi-calculator d-block fs-4 mb-1"></i>Penggajian
                </a>
            </div>
        </div>
    </div>
</div>
@else
<div class="alert alert-info border-0 shadow-sm">
    <i class="bi bi-info-circle me-2"></i>
    Anda login sebagai <strong>User</strong>. Hubungi admin untuk akses fitur penggajian.
</div>
@endif
@endsection
