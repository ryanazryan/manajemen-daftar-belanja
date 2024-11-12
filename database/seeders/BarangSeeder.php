<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Barang;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'nama_barang' => 'Laptop',
                'nama_orang' => 'Ahmad',
                'kuantitas' => 10,
                'harga_per_satuan' => 5000000,
                'keterangan' => 'Barang elektronik untuk kantor'
            ],
            [
                'nama_barang' => 'Printer',
                'nama_orang' => 'Budi',
                'kuantitas' => 5,
                'harga_per_satuan' => 1500000,
                'keterangan' => 'Printer untuk keperluan administrasi'
            ],
            [
                'nama_barang' => 'Meja Kantor',
                'nama_orang' => 'Citra',
                'kuantitas' => 20,
                'harga_per_satuan' => 750000,
                'keterangan' => 'Meja kerja karyawan'
            ]
        ];

        foreach ($data as $item) {
            Barang::create($item);
        }
    }
}
