<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    protected $table = 'pelanggan';
    protected $fillable = [
        'nama_panggilan',
        'nama_lengkap',
        'alamat',
        'tempat_lahir',
        'tanggal_lahir',
        'no_telepon',
        'active'
    ];
}
