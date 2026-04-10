@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <h4 class="mb-0"><i class="bi bi-receipt me-2"></i>Hasil Penggajian</h4>
    <a href="{{ route('penggajian.hitung') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i>Input Penggajian
    </a>
</div>

{{-- Filter periode + search --}}
<div class="card shadow-sm mb-3">
    <div class="card-body py-2">
        <form method="GET" action="{{ route('kategori.index') }}" class="row g-2 align-items-center">
            <div class="col-auto">
                <label class="col-form-label col-form-label-sm fw-semibold">Periode:</label>
            </div>
            <div class="col-auto">
                <input type="month" name="periode" class="form-control form-control-sm"
                       value="{{ $periode }}">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-sm btn-primary">
                    <i class="bi bi-filter me-1"></i>Tampilkan
                </button>
            </div>
            <div class="col-md-3 ms-auto">
                <div class="input-group input-group-sm">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" id="search-nama" class="form-control"
                           placeholder="Cari nama karyawan...">
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Tabel hasil penggajian --}}
<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-bordered mb-0">
                <thead class="table-primary text-center">
                    <tr>
                        <th class="align-middle" style="width:40px">No</th>
                        <th class="text-start align-middle" style="min-width:180px">Nama Karyawan</th>
                        <th class="text-success align-middle" style="min-width:130px">Kehadiran</th>
                        <th class="text-success align-middle" style="min-width:120px">Lembur</th>
                        <th class="text-success align-middle" style="min-width:130px">Perj. Dinas</th>
                        <th class="text-danger align-middle" style="min-width:120px">
                            Cuti<br><small class="fw-normal">(Potongan)</small>
                        </th>
                        <th class="text-primary align-middle" style="min-width:150px">Grand Total</th>
                        <th class="align-middle">Periode</th>
                    </tr>
                </thead>
                <tbody id="tbody-rekap">
                    @forelse($data as $i => $p)
                    <tr class="rekap-row" data-nama="{{ strtolower($p->karyawan->nama ?? '') }}">
                        <td class="text-center align-middle">{{ $i + 1 }}</td>
                        <td class="align-middle">
                            <div class="fw-semibold">{{ $p->karyawan->nama ?? '-' }}</div>
                            <small class="text-muted">{{ $p->karyawan->nip ?? '' }}</small>
                        </td>
                        <td class="text-end align-middle">
                            <span class="text-success fw-semibold">
                                Rp {{ number_format($p->total_hadir, 0, ',', '.') }}
                            </span>
                            <div class="text-muted" style="font-size:.75rem">{{ $p->jml_hadir }} hari</div>
                        </td>
                        <td class="text-end align-middle">
                            <span class="text-success fw-semibold">
                                Rp {{ number_format($p->total_lembur, 0, ',', '.') }}
                            </span>
                            <div class="text-muted" style="font-size:.75rem">{{ $p->jml_lembur }} jam</div>
                        </td>
                        <td class="text-end align-middle">
                            <span class="text-success fw-semibold">
                                Rp {{ number_format($p->total_dinas, 0, ',', '.') }}
                            </span>
                            <div class="text-muted" style="font-size:.75rem">{{ $p->jml_dinas }} perjalanan</div>
                        </td>
                        <td class="text-end align-middle">
                            <span class="text-danger fw-semibold">
                                - Rp {{ number_format($p->total_cuti, 0, ',', '.') }}
                            </span>
                            <div class="text-muted" style="font-size:.75rem">{{ $p->jml_cuti }} hari</div>
                        </td>
                        <td class="text-end align-middle">
                            <span class="fw-bold text-primary fs-6">
                                Rp {{ number_format($p->grand_total, 0, ',', '.') }}
                            </span>
                        </td>
                        <td class="text-center align-middle">
                            <span class="badge bg-secondary">
                                {{ \Carbon\Carbon::parse($p->periode)->format('M Y') }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-5">
                            <i class="bi bi-inbox fs-2 d-block mb-2 opacity-50"></i>
                            Belum ada data penggajian untuk periode ini.<br>
                            <a href="{{ route('penggajian.hitung') }}" class="btn btn-sm btn-primary mt-2">
                                <i class="bi bi-plus-lg me-1"></i>Input Sekarang
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>
</div>

<div class="mt-2 text-muted small">
    Menampilkan <span id="jml-tampil">{{ count($data) }}</span> karyawan
</div>

<script>
document.getElementById('search-nama').addEventListener('input', function () {
    const q = this.value.toLowerCase().trim();
    let tampil = 0;
    document.querySelectorAll('#tbody-rekap tr.rekap-row').forEach(tr => {
        const cocok = tr.dataset.nama.includes(q);
        tr.style.display = cocok ? '' : 'none';
        if (cocok) tampil++;
    });
    document.getElementById('jml-tampil').textContent = tampil;
});
</script>
@endsection
