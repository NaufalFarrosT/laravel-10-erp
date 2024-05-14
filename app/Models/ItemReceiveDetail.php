<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemReceiveDetail extends Model
{
    use HasFactory, SoftDeletes;

    public function purchaseDetail()
    {
        return $this->belongsTo(PurchaseDetail::class);
    }

    public function itemReceive()
    {
        return $this->belongsTo(ItemReceive::class);
    }
}
