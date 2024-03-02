<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';
    protected $fillable = ['nama', 'deskripsi', 'id_kategori', 'active', 'stok', 'harga'];

    public function satuan_beli(): HasMany
    {
        return $this->hasMany(SatuanBeli::class, 'id_produk', 'id');
    }

    public function kategori(): HasOne
    {
        return $this->hasOne(Kategori::class, 'id', 'id_kategori');
    }

    public function diskon(): HasOne
    {
        return $this->hasOne(Diskon::class, 'id_produk', 'id');
    }
}
