<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BenefitPoinMembership extends Model
{
    use HasFactory;

    protected $table = 'benefit_poin_membership';
    protected $fillable = ['id_benefit_membership', 'perolehan_poin'];
}
