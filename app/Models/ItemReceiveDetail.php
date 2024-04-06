<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemReceiveDetail extends Model
{
    use HasFactory;

    public function purchaseDetail()
    {
        return $this->belongsTo(PurchaseDetail::class);
    }
}
