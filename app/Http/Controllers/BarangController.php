<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        $barangs = Barang::all();
        return view('barang.index', compact('barangs'));
    }

    public function create()
    {
        return view('barang.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'nama_orang' => 'required|string|max:255',
            'kuantitas' => 'required|integer|min:1',
            'harga_per_satuan' => 'required|numeric|min:0',
        ]);

        Barang::create($request->all());
        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function show($id)
    {
        $barang = Barang::findOrFail($id);
        return view('barang.show', compact('barang'));
    }

    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        return view('barang.edit', compact('barang'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'nama_orang' => 'required|string|max:255',
            'kuantitas' => 'required|integer',
            'harga_per_satuan' => 'required|string',
            'keterangan' => 'nullable|string',
        ]);

        $barang = Barang::findOrFail($id);

        $hargaPerSatuan = str_replace(['Rp ', '.'], '', $request->harga_per_satuan);

        $barang->update([
            'nama_barang' => $request->nama_barang,
            'nama_orang' => $request->nama_orang,
            'kuantitas' => $request->kuantitas,
            'harga_per_satuan' => $hargaPerSatuan,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('barang.edit', $barang->id)->with('status', 'barang-updated');
    }



    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();

        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus.');
    }
}
