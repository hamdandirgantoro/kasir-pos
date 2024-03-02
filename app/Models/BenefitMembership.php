<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BenefitMembership extends Model
{
    use HasFactory;

    protected $table = 'benefit_membership';
    protected $fillable = ['diskon', 'perolehan_poin', 'active'];
}
