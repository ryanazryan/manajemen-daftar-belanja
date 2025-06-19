<?php

namespace App\Http\Controllers;

use App\Exports\BarangsExport;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class BarangController extends Controller
{


    public function index()
    {
        $totalKuantitas = Barang::sum('kuantitas');

        $grandTotalHarga = Barang::sum(DB::raw('kuantitas * harga_per_satuan'));

        $barangs = Barang::latest()->paginate(10);

        return view('barang.index', compact('barangs', 'totalKuantitas', 'grandTotalHarga'));
    }

    public function create()
    {
        return view('barang.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'nama_orang' => 'required|string|max:255',
            'kuantitas' => 'required|integer|min:1',
            'harga_per_satuan' => 'required|numeric|min:0',
            'tanggal' => 'nullable|date',
            'keterangan' => 'nullable|string'
        ]);

        Barang::create($validatedData);

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
        $validatedData = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'nama_orang' => 'required|string|max:255',
            'kuantitas' => 'required|integer',
            'harga_per_satuan' => 'required|string',
            'keterangan' => 'nullable|string',
            'tanggal' => 'nullable|date',
        ]);

        $barang = Barang::findOrFail($id);

        $hargaPerSatuan = str_replace(['Rp ', '.'], '', $request->harga_per_satuan);

        $barang->update([
            'nama_barang' => $request->nama_barang,
            'nama_orang' => $request->nama_orang,
            'kuantitas' => $request->kuantitas,
            'harga_per_satuan' => $hargaPerSatuan,
            'keterangan' => $request->keterangan,
            'tanggal' => $validatedData['tanggal']
        ]);

        return redirect()->route('barang.edit', $barang->id)->with('status', 'barang-updated');
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();

        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus.');
    }

    public function export()
    {
        $fileName = 'unit-usaha-dwp' . date('Y-m-d') . '.xlsx';

        return Excel::download(new BarangsExport, $fileName);
    }
}
