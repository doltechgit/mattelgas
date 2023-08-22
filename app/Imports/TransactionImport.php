<?php

namespace App\Imports;

use App\Models\Transaction;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use App\Imports\Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure as ValidatorsFailure;
use Throwable;

class TransactionImport implements ToCollection, WithHeadingRow, SkipsOnError, WithValidation, SkipsOnFailure{
    
    use Importable;
    public function collection(Collection $rows)
    {
        
        foreach ($rows as $row) 
        {
            Transaction::firstOrCreate([
            'transaction_id' => $row['transaction_id'],
            'product_id' => $row['product_id'],
            'store_id' => $row['store_id'],
            'client_id' => $row['client_id'],
            'user_id' => $row['user_id'],
            'quantity' => $row['quantity'],
            'price' => $row['price'],
            'discount' => $row['discount'] == '' ? 0 : $row['discount'] ,
            'paid' => $row['paid'] == '' ? 0 : $row['paid'],
            'balance' => $row['balance'] == '' ? 0 : $row['balance'],
            'pay_method' => $row['pay_method'],
            'created_at' => $row['created_at'],
            'updated_at' => $row['updated_at'],
        ]);
    }
    
    }

    public function uniqueBy() {
        return 'transaction_id';
    }

    public function rules(): array{
        return [
            '*.transaction_id' => ['unique:transactions']
        ];
    }

    public function onError(Throwable $e)
    {
        
    }
    public function onFailure(ValidatorsFailure ...$failures)
    {
        
    }
}

// class TransactionImport implements ToModel, WithHeadingRow{
//     /**
//     * @param array $row
//     *
//     * @return \Illuminate\Database\Eloquent\Model|null
//     */
//     public function model(array $row)
//     {
        
//             return new Transaction([
            
//             'transaction_id' => $row['transaction_id'],
//             'product_id' => $row['product_id'],
//             'store_id' => $row['store_id'],
//             'client_id' => $row['client_id'],
//             'user_id' => $row['user_id'],
//             'quantity' => $row['quantity'],
//             'price' => $row['price'],
//             'discount' => $row['discount'],
//             'paid' => $row['paid'],
//             'balance' => $row['balance'],
//             'pay_method' => $row['pay_method'],
//             'created_at' => $row['created_at'],
//             'updated_at' => $row['updated_at'],
//         ]);
    
//     }
// }
