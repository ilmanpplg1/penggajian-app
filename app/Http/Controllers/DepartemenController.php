<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use Illuminate\Http\Request;

class DepartemenController extends Controller
{
    public function index()
    {
        $departemens = Departemen::latest()->paginate(10);
        return view('departemen.index', compact('departemens'));
    }

    public function create()
    {
        $kode = $this->generateKode();
        return view('departemen.create', compact('kode'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_departemen' => 'required|string|max:100',
            'deskripsi'       => 'nullable|string',
        ]);

        Departemen::create([
            'kode_departemen' => $this->generateKode(),
            'nama_departemen' => $request->nama_departemen,
            'deskripsi'       => $request->deskripsi,
        ]);

        return redirect()->route('departemen.index')->with('success', 'Departemen berhasil ditambahkan.');
    }

    public function edit(Departemen $departemen)
    {
        return view('departemen.edit', compact('departemen'));
    }

    public function update(Request $request, Departemen $departemen)
    {
        $request->validate([
            'nama_departemen' => 'required|string|max:100',
            'deskripsi'       => 'nullable|string',
        ]);

        $departemen->update($request->only('nama_departemen', 'deskripsi'));

        return redirect()->route('departemen.index')->with('success', 'Departemen berhasil diperbarui.');
    }

    private function generateKode(): string
    {
        $last = Departemen::orderBy('id', 'desc')->first();
        $next = $last ? ((int) substr($last->kode_departemen, -3)) + 1 : 1;
        return 'DEPT-' . str_pad($next, 3, '0', STR_PAD_LEFT);
    }

    public function destroy(Departemen $departemen)
    {
        $departemen->delete();
        return redirect()->route('departemen.index')->with('success', 'Departemen berhasil dihapus.');
    }
}
