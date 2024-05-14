<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    public function purchase_details() {
        return $this->hasMany(PurchaseDetail::class);
    }

    public function item_receives() {
        return $this->hasMany(ItemReceive::class);
    }

    public function payments(){
        return $this->hasMany(PurchasePayment::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
