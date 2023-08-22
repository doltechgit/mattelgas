<?php

namespace App\Imports;

use App\Models\Stock;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure as ValidatorsFailure;
use Throwable;

class StockImport implements ToModel, WithHeadingRow,WithValidation,SkipsOnError, SkipsOnFailure
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Stock([
            'id' => $row['id'],
            'stock_stamp' => $row['stock_stamp'],
            'product_id' => $row['product_id'],
            'prev_quantity' => $row['prev_quantity'],
            'add_quantity' => $row['add_quantity'],
            'new_quantity' => $row['new_quantity'],
            'store_id' => $row['store_id'],
            'user_id' => $row['user_id'],
            'created_at' => $row['created_at'],
            'updated_at' => $row['updated_at']
            
        ]);
    }

    public function rules(): array{
        return [
            '*.stock_stamp' => ['unique:stocks']
        ];
    }

    public function onError(Throwable $e)
    {
        
    }
    public function onFailure(ValidatorsFailure ...$failures)
    {
        
    }
}
