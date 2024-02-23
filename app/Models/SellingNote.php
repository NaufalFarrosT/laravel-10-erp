<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellingNote extends Model
{
    use HasFactory;

    public function selling_details() {
        return $this->belongsToMany(Item::class)->as('selling_details');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
