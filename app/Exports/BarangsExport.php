<?php

namespace App\Exports;

use App\Models\Barang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BarangsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Barang::select('id', 'nama_barang', 'nama_orang', 'kuantitas', 'harga_per_satuan', 'tanggal', 'keterangan')->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Nama Barang',
            'Nama Orang',
            'Kuantitas',
            'Harga Per Satuan',
            'Tanggal',
            'Keterangan',
        ];
    }
}