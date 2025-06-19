<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barang';
    protected $fillable = ['nama_barang', 'nama_orang', 'kuantitas', 'harga_per_satuan', 'tanggal','keterangan'];
    protected $casts = [
        'tanggal' => 'date',
    ];

    public static function boot()
    {
        parent::boot();

        static::saving(function ($barang){
            $barang->harga_total = $barang->kuantitas * $barang->harga_per_satuan;
        });
        
    }
}
