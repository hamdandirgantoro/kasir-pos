<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BenefitDiskonMembership extends Model
{
    use HasFactory;

    protected $table = 'benefit_diskon_membership';
    protected $fillable = ['id_benefit_membership', 'tipe', 'diskon'];
}
