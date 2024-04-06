<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemReceive extends Model
{
    use HasFactory;

    public function warehouse()
    {
        return $this->belongsTo(warehouse::class);
    }

    public function itemReceiveDetails() {
        return $this->hasMany(ItemReceiveDetail::class);
    }
}
