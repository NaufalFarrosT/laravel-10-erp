<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function purchasing_details() {
        return $this->belongsToMany(PurchasingNote::class)->as('purchasing_details');
    }

    public function selling_details() {
        return $this->belongsToMany(SellingNote::class)->as('selling_details');
    }
}
