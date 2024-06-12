<?php

namespace App\Imports;

use App\Models\Item;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ItemImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    // public function model(array $row)
    // {
    //     return new Item([
    //         //
    //     ]);
    // }

    public function model(array $row)
    {
        return new Item([
            'name' => $row['nama'],
            'selling_price' => $row['harga_jual'],
            'buying_price' => $row['harga_beli'],
            'stock' => $row['stok'],
            'category_id' => $row['id_kategori'],
            'unit_id' => $row['id_unit'],
            // Map other fields as necessary
        ]);
    }
}
