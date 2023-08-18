<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TransactionUpdateExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Transaction::all();
    }

    public function headings(): array
    {
        return [
            'id',
            'transaction_id',
            'product_id',
            'store_id',
            'client_id',
            'user_id',
            'quantity',
            'price',
            'discount',
            'paid',
            'balance',
            'pay_method',
            'created_at',
            'updated_at'
        ];
    }
}
