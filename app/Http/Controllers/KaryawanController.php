<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Jabatan;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    public function index()
    {
        $karyawans = Karyawan::with('jabatan.departemen')->latest()->paginate(10);
        return view('karyawan.index', compact('karyawans'));
    }

    public function create()
    {
        $jabatans = Jabatan::with('departemen')->orderBy('nama_jabatan')->get();
        return view('karyawan.create', compact('jabatans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'          => 'required|string|max:100',
            'nip'           => 'required|string|max:20|unique:karyawans',
            'email'         => 'required|email|unique:karyawans',
            'no_hp'         => 'required|string|max:20',
            'alamat'        => 'required|string',
            'jabatan_id'    => 'required|exists:jabatans,id',
            'tanggal_masuk' => 'required|date',
        ]);

        Karyawan::create($request->all());

        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil ditambahkan.');
    }

    public function edit(Karyawan $karyawan)
    {
        $jabatans = Jabatan::with('departemen')->orderBy('nama_jabatan')->get();
        return view('karyawan.edit', compact('karyawan', 'jabatans'));
    }

    public function update(Request $request, Karyawan $karyawan)
    {
        $request->validate([
            'nama'          => 'required|string|max:100',
            'nip'           => 'required|string|max:20|unique:karyawans,nip,' . $karyawan->id,
            'email'         => 'required|email|unique:karyawans,email,' . $karyawan->id,
            'no_hp'         => 'required|string|max:20',
            'alamat'        => 'required|string',
            'jabatan_id'    => 'required|exists:jabatans,id',
            'tanggal_masuk' => 'required|date',
        ]);

        $karyawan->update($request->all());

        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil diperbarui.');
    }

    public function destroy(Karyawan $karyawan)
    {
        $karyawan->delete();
        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil dihapus.');
    }
}
