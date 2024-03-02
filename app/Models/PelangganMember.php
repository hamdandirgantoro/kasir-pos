<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PelangganMember extends Model
{
    use HasFactory;

    protected $table = 'pelanggan_member';
    protected $fillable = ['id_pelanggan', 'poin'];

    public function pelanggan(): HasOne
    {
        return $this->hasOne(Pelanggan::class, 'id', 'id_pelanggan');
    }
}
