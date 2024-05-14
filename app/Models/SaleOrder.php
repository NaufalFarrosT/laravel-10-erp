<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SaleOrder extends Model
{
    use HasFactory, SoftDeletes;

    public function sale_details() {
        return $this->hasMany(SaleDetail::class);
    }

    public function payments(){
        return $this->hasMany(SalePayment::class);
    }
}
