<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Kategori;
use App\Models\Penggajian;
use Illuminate\Http\Request;

class PenggajianController extends Controller
{
    // Halaman form hitung
    public function hitung()
    {
        $karyawans = Karyawan::with('jabatan')->orderBy('nama')->get();
        return view('penggajian.hitung', compact('karyawans'));
    }

    // Simpan hasil penggajian dari form
    public function store(Request $request)
    {
        $request->validate([
            'karyawan_id'    => 'required|exists:karyawans,id',
            'jml_hadir'      => 'required|integer|min:0',
            'nominal_hadir'  => 'required|integer|min:0',
            'jml_lembur'     => 'required|integer|min:0',
            'nominal_lembur' => 'required|integer|min:0',
            'jml_dinas'      => 'required|integer|min:0',
            'nominal_dinas'  => 'required|integer|min:0',
            'jml_cuti'       => 'required|integer|min:0',
            'nominal_cuti'   => 'required|integer|min:0',
            'periode'        => 'required|date',
        ]);

        $totalHadir  = $request->jml_hadir  * $request->nominal_hadir;
        $totalLembur = $request->jml_lembur * $request->nominal_lembur;
        $totalDinas  = $request->jml_dinas  * $request->nominal_dinas;
        $totalCuti   = $request->jml_cuti   * $request->nominal_cuti;
        $grandTotal  = ($totalHadir + $totalLembur + $totalDinas) - $totalCuti;

        Penggajian::create([
            'karyawan_id'    => $request->karyawan_id,
            'jml_hadir'      => $request->jml_hadir,
            'nominal_hadir'  => $request->nominal_hadir,
            'jml_lembur'     => $request->jml_lembur,
            'nominal_lembur' => $request->nominal_lembur,
            'jml_dinas'      => $request->jml_dinas,
            'nominal_dinas'  => $request->nominal_dinas,
            'jml_cuti'       => $request->jml_cuti,
            'nominal_cuti'   => $request->nominal_cuti,
            'total_hadir'    => $totalHadir,
            'total_lembur'   => $totalLembur,
            'total_dinas'    => $totalDinas,
            'total_cuti'     => $totalCuti,
            'grand_total'    => $grandTotal,
            'periode'        => $request->periode,
        ]);

        return response()->json(['message' => 'Berhasil disimpan.']);
    }

    // Halaman rekap hasil penggajian (dipakai oleh route kategori.index)
    public function rekapKategori(Request $request)
    {
        $periode = $request->periode ?? now()->format('Y-m');

        $data = Penggajian::with('karyawan.jabatan')
            ->whereRaw("DATE_FORMAT(periode, '%Y-%m') = ?", [$periode])
            ->orderBy('created_at', 'desc')
            ->get()
            ->unique('karyawan_id')
            ->values();

        return view('kategori.index', compact('data', 'periode'));
    }

    // Halaman rekap hasil penggajian
    public function rekap(Request $request)
    {
        $periode = $request->periode ?? now()->format('Y-m');

        $data = Penggajian::with('karyawan.jabatan.departemen')
            ->whereRaw("DATE_FORMAT(periode, '%Y-%m') = ?", [$periode])
            ->orderBy('created_at', 'desc')
            ->get()
            ->unique('karyawan_id') // tampilkan data terbaru per karyawan
            ->values();

        return view('penggajian.rekap', compact('data', 'periode'));
    }
}
