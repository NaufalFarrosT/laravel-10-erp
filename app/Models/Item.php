<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory, SoftDeletes;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function purchasing_details() {
        return $this->belongsToMany(PurchaseDetail::class);
    }

    public function selling_details() {
        return $this->belongsToMany(SaleOrder::class);
    }

    public function warehouses(){
        return $this->hasMany(WarehouseItem::class);
    }
}
