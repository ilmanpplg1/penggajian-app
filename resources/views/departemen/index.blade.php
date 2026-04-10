@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0"><i class="bi bi-building me-2"></i>Departemen</h4>
    <a href="{{ route('departemen.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Tambah Departemen
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-primary">
                <tr>
                    <th>#</th>
                    <th>Kode</th>
                    <th>Nama Departemen</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($departemens as $item)
                <tr>
                    <td>{{ $departemens->firstItem() + $loop->index }}</td>
                    <td><span class="badge bg-secondary">{{ $item->kode_departemen }}</span></td>
                    <td>{{ $item->nama_departemen }}</td>
                    <td>{{ $item->deskripsi ?? '-' }}</td>
                    <td>
                        <a href="{{ route('departemen.edit', $item) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('departemen.destroy', $item) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Hapus departemen ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">Belum ada data departemen.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $departemens->links() }}</div>
@endsection
