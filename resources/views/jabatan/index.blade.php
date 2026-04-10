@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0"><i class="bi bi-briefcase me-2"></i>Jabatan</h4>
    <a href="{{ route('jabatan.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Tambah Jabatan
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-primary">
                <tr>
                    <th>#</th>
                    <th>Nama Jabatan</th>
                    <th>Departemen</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jabatans as $item)
                <tr>
                    <td>{{ $jabatans->firstItem() + $loop->index }}</td>
                    <td>{{ $item->nama_jabatan }}</td>
                    <td>{{ $item->departemen->nama_departemen ?? '-' }}</td>
                    <td>
                        <a href="{{ route('jabatan.edit', $item) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('jabatan.destroy', $item) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Hapus jabatan ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted py-4">Belum ada data jabatan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $jabatans->links() }}</div>
@endsection
