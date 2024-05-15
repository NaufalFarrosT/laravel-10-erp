<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemReceive extends Model
{
    use HasFactory, SoftDeletes;

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function itemReceiveDetails() {
        return $this->hasMany(ItemReceiveDetail::class);
    }
}
