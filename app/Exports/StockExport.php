<?php

namespace App\Exports;

use App\Models\Stock;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StockExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Stock::all();
    }

    public function headings(): array
    {
        return [
            'id',
            'stock_stamp',
            'product_id',
            'prev_quantity',
            'add_quantity',
            'new_quantity',
            'store_id',
            'user_id',
            'created_at',
            'updated_at'
        ];
    }
}
