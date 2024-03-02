<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diskon extends Model
{
    use HasFactory;
    protected $table = 'diskon';
    protected $fillable = ['id_produk', 'diskon', 'masa_berlaku', 'type', 'active'];
}
