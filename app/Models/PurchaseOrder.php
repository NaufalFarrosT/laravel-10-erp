<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    public function purchasing_details() {
        return $this->belongsToMany(Item::class)->as('purchasing_details');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
