<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatProdukTransaksi extends Model
{
    use HasFactory;

    protected $table = 'riwayat_produk_transaksi';
    protected $fillable = [
        'id_produk',
        'satuan_beli',
        'diskon',
        'harga',
        'subtotal',
        'id_riwayat_transaksi',
        'jumlah',
        'nama_produk'
    ];
}
