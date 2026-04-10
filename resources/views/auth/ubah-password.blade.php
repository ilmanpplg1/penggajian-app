@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white fw-semibold">
                <i class="bi bi-key me-2"></i>Ubah Password
            </div>
            <div class="card-body">
                <form action="{{ route('ubah-password') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Password Lama <span class="text-danger">*</span></label>
                        <input type="password" name="password_lama"
                               class="form-control @error('password_lama') is-invalid @enderror"
                               placeholder="Masukkan password lama">
                        @error('password_lama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password Baru <span class="text-danger">*</span></label>
                        <input type="password" name="password_baru"
                               class="form-control @error('password_baru') is-invalid @enderror"
                               placeholder="Minimal 6 karakter">
                        @error('password_baru')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                        <input type="password" name="password_baru_confirmation"
                               class="form-control"
                               placeholder="Ulangi password baru">
                    </div>

                    <button type="submit" class="btn btn-primary w-100 fw-semibold">
                        <i class="bi bi-save me-1"></i>Simpan Password Baru
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
