@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-xl-10">

        <h4 class="mb-4"><i class="bi bi-cash-coin me-2"></i>Form Penggajian Karyawan</h4>

        {{-- Pilih Karyawan --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-dark text-white fw-semibold">
                <i class="bi bi-person-fill me-2"></i>Data Karyawan
            </div>
            <div class="card-body">
                <div class="row align-items-end g-3">
                    <div class="col-md-6">
                        <label class="form-label">Pilih Karyawan <span class="text-danger">*</span></label>
                        <select id="karyawan_id" class="form-select">
                            <option value="">-- Pilih Karyawan --</option>
                            @foreach($karyawans as $k)
                                <option value="{{ $k->id }}"
                                        data-nama="{{ $k->nama }}"
                                        data-nip="{{ $k->nip }}"
                                        data-jabatan="{{ $k->jabatan->nama_jabatan ?? '-' }}">
                                    {{ $k->nama }} — {{ $k->nip }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6" id="info-karyawan-box" style="display:none">
                        <div class="bg-light rounded p-3">
                            <div class="fw-bold" id="ik-nama">-</div>
                            <small class="text-muted">NIP: <span id="ik-nip">-</span> &nbsp;|&nbsp; Jabatan: <span id="ik-jabatan">-</span></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabel Kategori Dinamis --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white fw-semibold d-flex justify-content-between align-items-center">
                <span><i class="bi bi-table me-2"></i>Rincian Komponen Gaji</span>
                <button type="button" id="btn-add-row" class="btn btn-light btn-sm">
                    <i class="bi bi-plus-lg me-1"></i>Tambah Baris
                </button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0" id="tabel-gaji">
                        <thead class="table-light">
                            <tr>
                                <th style="width:35%">Kategori</th>
                                <th style="width:15%">Jumlah</th>
                                <th style="width:25%">Nominal (Rp)</th>
                                <th style="width:18%">Subtotal</th>
                                <th style="width:7%"></th>
                            </tr>
                        </thead>
                        <tbody id="tbody-gaji">
                            {{-- baris diisi JS --}}
                        </tbody>
                        <tfoot>
                            <tr class="table-light">
                                <td colspan="3" class="text-end pe-3 text-success">Total Penambah</td>
                                <td id="total-tambah" class="text-success fw-semibold">Rp 0</td>
                                <td></td>
                            </tr>
                            <tr class="table-primary fw-bold">
                                <td colspan="3" class="text-end pe-3">Grand Total</td>
                                <td id="grand-total" class="text-primary fs-6">Rp 0</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        {{-- Slip Hasil --}}
        <div id="slip-box" class="card shadow-sm border-primary d-none">
            <div class="card-header bg-primary text-white fw-semibold">
                <i class="bi bi-receipt me-2"></i>Slip Gaji
            </div>
            <div class="card-body" id="slip-content"></div>
        </div>

        <div class="d-flex gap-2 mt-3">
            <button type="button" id="btn-hitung" class="btn btn-primary px-4 fw-semibold">
                <i class="bi bi-calculator me-2"></i>Hitung & Tampilkan Slip
            </button>
            <button type="button" id="btn-simpan" class="btn btn-success px-4 fw-semibold" style="display:none">
                <i class="bi bi-save me-2"></i>Simpan Hasil
            </button>
            <button type="button" id="btn-reset" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-counterclockwise me-1"></i>Reset
            </button>
        </div>

        {{-- Input periode (muncul setelah hitung) --}}
        <div id="periode-box" class="mt-3" style="display:none">
            <div class="row">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Periode Gaji <span class="text-danger">*</span></label>
                    <input type="month" id="inp-periode" class="form-control"
                           value="{{ now()->format('Y-m') }}">
                </div>
            </div>
        </div>

        <div id="alert-simpan" class="mt-3" style="display:none"></div>

    </div>
</div>

<script>
// ─── Data kategori dari API ───────────────────────────────────────────────────
let KATEGORIS = [];

async function loadKategoris() {
    try {
        const res = await fetch('{{ route("api.kategoris") }}');
        KATEGORIS = await res.json();
    } catch (e) {
        console.error('Gagal load kategori', e);
    }
}

// ─── Format Rupiah ────────────────────────────────────────────────────────────
const fmt = n => 'Rp ' + Math.max(0, n).toLocaleString('id-ID');

// ─── Buat baris baru ──────────────────────────────────────────────────────────
function buatBaris() {
    const tr = document.createElement('tr');
    tr.innerHTML = `
        <td>
            <select class="form-select form-select-sm sel-kategori">
                <option value="">-- Pilih --</option>
                ${KATEGORIS.map(k =>
                    `<option value="${k.id}"
                             data-nominal="${k.nominal_default}"
                             data-satuan="${k.satuan}"
                             data-deduction="${k.is_deduction ? '1' : '0'}">
                        ${k.nama_kategori}${k.is_deduction ? ' (Potongan)' : ''}
                    </option>`
                ).join('')}
            </select>
        </td>
        <td>
            <input type="number" class="form-control form-control-sm inp-jumlah"
                   min="0" value="0" placeholder="0">
        </td>
        <td>
            <div class="input-group input-group-sm">
                <span class="input-group-text">Rp</span>
                <input type="number" class="form-control inp-nominal"
                       min="0" value="0" placeholder="0">
            </div>
            <small class="text-muted satuan-label"></small>
        </td>
        <td class="fw-semibold text-success subtotal-cell align-middle">Rp 0</td>
        <td class="text-center align-middle">
            <button type="button" class="btn btn-sm btn-outline-danger btn-hapus">
                <i class="bi bi-trash"></i>
            </button>
        </td>
    `;

    // Event: pilih kategori → isi nominal otomatis
    tr.querySelector('.sel-kategori').addEventListener('change', function () {
        const opt        = this.options[this.selectedIndex];
        const nominal    = opt.dataset.nominal    ?? 0;
        const satuan     = opt.dataset.satuan     ?? '';
        const isDeduct   = opt.dataset.deduction  === '1';
        tr.querySelector('.inp-nominal').value = nominal;
        tr.querySelector('.satuan-label').textContent = satuan ? `per ${satuan}` : '';
        // tandai baris sebagai potongan
        tr.dataset.deduction = isDeduct ? '1' : '0';
        hitungBaris(tr);
    });

    // Event: ubah jumlah / nominal → hitung subtotal
    tr.querySelector('.inp-jumlah').addEventListener('input', () => hitungBaris(tr));
    tr.querySelector('.inp-nominal').addEventListener('input', () => hitungBaris(tr));

    // Event: hapus baris
    tr.querySelector('.btn-hapus').addEventListener('click', () => {
        tr.remove();
        hitungTotal();
    });

    return tr;
}

// ─── Hitung subtotal 1 baris ──────────────────────────────────────────────────
function hitungBaris(tr) {
    const jumlah     = parseFloat(tr.querySelector('.inp-jumlah').value)  || 0;
    const nominal    = parseFloat(tr.querySelector('.inp-nominal').value) || 0;
    const isDeduct   = tr.dataset.deduction === '1';
    const subtotal   = jumlah * nominal;
    const cell       = tr.querySelector('.subtotal-cell');
    cell.textContent = (isDeduct ? '- ' : '') + fmt(subtotal);
    cell.className   = `fw-semibold subtotal-cell align-middle ${isDeduct ? 'text-danger' : 'text-success'}`;
    hitungTotal();
}

// ─── Hitung grand total semua baris ──────────────────────────────────────────
function hitungTotal() {
    let tambah = 0;
    let potong = 0;
    document.querySelectorAll('#tbody-gaji tr').forEach(tr => {
        const jumlah   = parseFloat(tr.querySelector('.inp-jumlah')?.value)  || 0;
        const nominal  = parseFloat(tr.querySelector('.inp-nominal')?.value) || 0;
        const isDeduct = tr.dataset.deduction === '1';
        if (isDeduct) potong += jumlah * nominal;
        else          tambah += jumlah * nominal;
    });
    const total = tambah - potong;
    document.getElementById('total-tambah').textContent = fmt(tambah);
    // total-potong disembunyikan dari UI tapi tetap dihitung di background
    const el = document.getElementById('grand-total');
    el.textContent = fmt(Math.max(0, total));
    el.className   = total < 0 ? 'text-danger fs-6' : 'text-primary fs-6';
    return total;
}

// ─── Tambah baris ─────────────────────────────────────────────────────────────
document.getElementById('btn-add-row').addEventListener('click', () => {
    document.getElementById('tbody-gaji').appendChild(buatBaris());
});

// ─── Info karyawan saat dipilih ───────────────────────────────────────────────
document.getElementById('karyawan_id').addEventListener('change', function () {
    const opt = this.options[this.selectedIndex];
    const box = document.getElementById('info-karyawan-box');
    if (this.value) {
        document.getElementById('ik-nama').textContent    = opt.dataset.nama;
        document.getElementById('ik-nip').textContent     = opt.dataset.nip;
        document.getElementById('ik-jabatan').textContent = opt.dataset.jabatan;
        box.style.display = 'block';
    } else {
        box.style.display = 'none';
    }
});

// ─── Hitung & tampilkan slip ──────────────────────────────────────────────────
document.getElementById('btn-hitung').addEventListener('click', () => {
    const sel = document.getElementById('karyawan_id');
    if (!sel.value) {
        sel.classList.add('is-invalid');
        sel.focus();
        return;
    }
    sel.classList.remove('is-invalid');

    const rows = document.querySelectorAll('#tbody-gaji tr');
    if (rows.length === 0) {
        alert('Tambahkan minimal 1 baris komponen gaji.');
        return;
    }

    const opt  = sel.options[sel.selectedIndex];
    let rincianHtml = '';
    let total = 0;

    rows.forEach(tr => {
        const katOpt   = tr.querySelector('.sel-kategori').options[tr.querySelector('.sel-kategori').selectedIndex];
        const katNama  = katOpt.value ? katOpt.text : '(belum dipilih)';
        const jumlah   = parseFloat(tr.querySelector('.inp-jumlah').value)  || 0;
        const nominal  = parseFloat(tr.querySelector('.inp-nominal').value) || 0;
        const isDeduct = tr.dataset.deduction === '1';
        const subtotal = jumlah * nominal;
        total += isDeduct ? -subtotal : subtotal;

        rincianHtml += `
            <tr>
                <td>
                    ${katNama}
                    ${isDeduct ? '<span class="badge bg-danger ms-1">Potongan</span>' : ''}
                </td>
                <td class="text-center">${jumlah}</td>
                <td class="text-end">${fmt(nominal)}</td>
                <td class="text-end fw-semibold ${isDeduct ? 'text-danger' : 'text-success'}">
                    ${isDeduct ? '- ' : ''}${fmt(subtotal)}
                </td>
            </tr>`;
    });

    document.getElementById('slip-content').innerHTML = `
        <div class="bg-light rounded p-3 mb-3">
            <div class="fw-bold fs-6">${opt.dataset.nama}</div>
            <small class="text-muted">NIP: ${opt.dataset.nip} &nbsp;|&nbsp; Jabatan: ${opt.dataset.jabatan}</small>
        </div>
        <table class="table table-sm table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Kategori</th>
                    <th class="text-center">Jumlah</th>
                    <th class="text-end">Nominal</th>
                    <th class="text-end">Subtotal</th>
                </tr>
            </thead>
            <tbody>${rincianHtml}</tbody>
            <tfoot>
                <tr class="table-primary fw-bold">
                    <td colspan="3" class="text-end">Total Gaji</td>
                    <td class="text-end text-primary fs-6">${fmt(total)}</td>
                </tr>
            </tfoot>
        </table>`;

    const slipBox = document.getElementById('slip-box');
    slipBox.classList.remove('d-none');
    slipBox.scrollIntoView({ behavior: 'smooth' });

    // Tampilkan tombol simpan & input periode
    document.getElementById('btn-simpan').style.display  = '';
    document.getElementById('periode-box').style.display = '';
});

// ─── Reset ────────────────────────────────────────────────────────────────────
document.getElementById('btn-reset').addEventListener('click', () => {
    document.getElementById('karyawan_id').value = '';
    document.getElementById('info-karyawan-box').style.display = 'none';
    document.getElementById('tbody-gaji').innerHTML = '';
    document.getElementById('grand-total').textContent = 'Rp 0';
    document.getElementById('slip-box').classList.add('d-none');
    document.getElementById('btn-simpan').style.display  = 'none';
    document.getElementById('periode-box').style.display = 'none';
    document.getElementById('alert-simpan').style.display = 'none';
    hitungTotal();
});

// ─── Simpan hasil ke database ─────────────────────────────────────────────────
document.getElementById('btn-simpan').addEventListener('click', async () => {
    const sel     = document.getElementById('karyawan_id');
    const periode = document.getElementById('inp-periode').value;

    if (!periode) {
        alert('Pilih periode gaji terlebih dahulu.');
        return;
    }

    // Kumpulkan data per kategori dari baris tabel
    let jmlHadir = 0, nomHadir = 0;
    let jmlLembur = 0, nomLembur = 0;
    let jmlDinas = 0, nomDinas = 0;
    let jmlCuti = 0, nomCuti = 0;

    document.querySelectorAll('#tbody-gaji tr').forEach(tr => {
        const katOpt  = tr.querySelector('.sel-kategori');
        const katNama = katOpt.options[katOpt.selectedIndex].text.replace(' (Potongan)', '').trim();
        const jumlah  = parseFloat(tr.querySelector('.inp-jumlah').value)  || 0;
        const nominal = parseFloat(tr.querySelector('.inp-nominal').value) || 0;

        if (katNama === 'Kehadiran')        { jmlHadir  = jumlah; nomHadir  = nominal; }
        if (katNama === 'Lembur')           { jmlLembur = jumlah; nomLembur = nominal; }
        if (katNama === 'Perjalanan Dinas') { jmlDinas  = jumlah; nomDinas  = nominal; }
        if (katNama === 'Cuti')             { jmlCuti   = jumlah; nomCuti   = nominal; }
    });

    const btn = document.getElementById('btn-simpan');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';

    try {
        const res = await fetch('{{ route("penggajian.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify({
                karyawan_id:    sel.value,
                jml_hadir:      jmlHadir,  nominal_hadir:  nomHadir,
                jml_lembur:     jmlLembur, nominal_lembur: nomLembur,
                jml_dinas:      jmlDinas,  nominal_dinas:  nomDinas,
                jml_cuti:       jmlCuti,   nominal_cuti:   nomCuti,
                periode:        periode + '-01',
            }),
        });

        const json = await res.json();
        const alertEl = document.getElementById('alert-simpan');
        alertEl.style.display = '';
        if (res.ok) {
            alertEl.innerHTML = `<div class="alert alert-success"><i class="bi bi-check-circle me-2"></i>${json.message} <a href="{{ route('penggajian.rekap') }}" class="alert-link">Lihat Rekap →</a></div>`;
            btn.innerHTML = '<i class="bi bi-check-lg me-2"></i>Tersimpan';
        } else {
            alertEl.innerHTML = `<div class="alert alert-danger"><i class="bi bi-x-circle me-2"></i>Gagal menyimpan. Coba lagi.</div>`;
            btn.disabled = false;
            btn.innerHTML = '<i class="bi bi-save me-2"></i>Simpan Hasil';
        }
    } catch (e) {
        alert('Terjadi kesalahan koneksi.');
        btn.disabled = false;
        btn.innerHTML = '<i class="bi bi-save me-2"></i>Simpan Hasil';
    }
});

// ─── Init: load kategori lalu tambah 1 baris default ─────────────────────────
loadKategoris().then(() => {
    document.getElementById('tbody-gaji').appendChild(buatBaris());
});
</script>
@endsection
