<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RiwayatTransaksi extends Model
{
    use HasFactory;
    protected $table = 'riwayat_transaksi';
    protected $fillable = [
                           'code',
                           'id_pelanggan',
                           'id_transaksi',
                           'nama_pelanggan',
                           'pelanggan_member',
                           'total',
                           'total_before',
                           'type',
                           'jumlah'
                        ];

    public function riwayat_produk_transaksi():HasMany
    {
        return $this->hasMany(RiwayatProdukTransaksi::class, 'id_transaksi', 'id');
    }
}
