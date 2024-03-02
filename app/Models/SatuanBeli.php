<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SatuanBeli extends Model
{
    use HasFactory;
    protected $table = 'satuan_beli';
    protected $fillable = ['id_produk', 'nama', 'aktif', 'default', 'konversi'];
}
