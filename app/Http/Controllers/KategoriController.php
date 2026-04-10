<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::latest()->get();
        return view('kategori.index', compact('kategoris'));
    }

    public function create()
    {
        return view('kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori'   => 'required|string|max:100|unique:kategoris,nama_kategori',
            'nominal_default' => 'required|integer|min:0',
            'satuan'          => 'required|string|max:50',
        ]);

        Kategori::create([
            'nama_kategori'   => $request->nama_kategori,
            'nominal_default' => $request->nominal_default,
            'satuan'          => $request->satuan,
            'is_deduction'    => $request->boolean('is_deduction'),
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Kategori $kategori)
    {
        return view('kategori.edit', compact('kategori'));
    }

    public function update(Request $request, Kategori $kategori)
    {
        $request->validate([
            'nama_kategori'   => 'required|string|max:100|unique:kategoris,nama_kategori,' . $kategori->id,
            'nominal_default' => 'required|integer|min:0',
            'satuan'          => 'required|string|max:50',
        ]);

        $kategori->update([
            'nama_kategori'   => $request->nama_kategori,
            'nominal_default' => $request->nominal_default,
            'satuan'          => $request->satuan,
            'is_deduction'    => $request->boolean('is_deduction'),
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Kategori $kategori)
    {
        $kategori->delete();
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }

    // API untuk JavaScript fetch — distinct untuk jaga-jaga
    public function apiList()
    {
        return response()->json(
            Kategori::orderBy('nama_kategori')->get()->unique('nama_kategori')->values()
        );
    }
}
