<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Product([
            //
            'product_name' => $row['product_name'],
            'product_price' => $row['product_price'],
            'product_category' => $row['product_category'],
            'product_stock' => $row['product_stock'],
            'product_description' => $row['product_description'],
            'product_image' => 'noimg.png',
        ]);
    }
}
