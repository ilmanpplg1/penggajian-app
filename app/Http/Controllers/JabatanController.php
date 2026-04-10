<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Models\Departemen;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    public function index()
    {
        $jabatans = Jabatan::with('departemen')->latest()->paginate(10);
        return view('jabatan.index', compact('jabatans'));
    }

    public function create()
    {
        $departemens = Departemen::orderBy('nama_departemen')->get();
        return view('jabatan.create', compact('departemens'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_jabatan'  => 'required|string|max:100',
            'departemen_id' => 'required|exists:departemens,id',
        ]);

        Jabatan::create($request->only('nama_jabatan', 'departemen_id'));

        return redirect()->route('jabatan.index')->with('success', 'Jabatan berhasil ditambahkan.');
    }

    public function edit(Jabatan $jabatan)
    {
        $departemens = Departemen::orderBy('nama_departemen')->get();
        return view('jabatan.edit', compact('jabatan', 'departemens'));
    }

    public function update(Request $request, Jabatan $jabatan)
    {
        $request->validate([
            'nama_jabatan'  => 'required|string|max:100',
            'departemen_id' => 'required|exists:departemens,id',
        ]);

        $jabatan->update($request->only('nama_jabatan', 'departemen_id'));

        return redirect()->route('jabatan.index')->with('success', 'Jabatan berhasil diperbarui.');
    }

    public function destroy(Jabatan $jabatan)
    {
        $jabatan->delete();
        return redirect()->route('jabatan.index')->with('success', 'Jabatan berhasil dihapus.');
    }
}
