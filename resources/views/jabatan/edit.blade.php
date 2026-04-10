@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card shadow-sm">
            <div class="card-header bg-warning">
                <i class="bi bi-pencil-square me-2"></i>Edit Jabatan
            </div>
            <div class="card-body">
                <form action="{{ route('jabatan.update', $jabatan) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Nama Jabatan <span class="text-danger">*</span></label>
                        <input type="text" name="nama_jabatan"
                               class="form-control @error('nama_jabatan') is-invalid @enderror"
                               value="{{ old('nama_jabatan', $jabatan->nama_jabatan) }}">
                        @error('nama_jabatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Departemen <span class="text-danger">*</span></label>
                        <select name="departemen_id"
                                class="form-select @error('departemen_id') is-invalid @enderror">
                            <option value="">-- Pilih Departemen --</option>
                            @foreach($departemens as $dep)
                                <option value="{{ $dep->id }}"
                                    {{ old('departemen_id', $jabatan->departemen_id) == $dep->id ? 'selected' : '' }}>
                                    {{ $dep->nama_departemen }}
                                </option>
                            @endforeach
                        </select>
                        @error('departemen_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-save me-1"></i>Update
                        </button>
                        <a href="{{ route('jabatan.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
