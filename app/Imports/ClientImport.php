<?php

namespace App\Imports;

use App\Models\Client;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure as ValidatorsFailure;
use Throwable;

class ClientImport implements ToCollection, WithHeadingRow, SkipsOnError, SkipsOnFailure, WithBatchInserts, WithUpserts
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {

        foreach ($rows as $row) {
          Client::create([
            'id' => $row['id'],
            'name' => $row['name'],
            'phone' => $row['phone'],
            'email' => $row['email'],
            'address' => $row['address'],
            'dob' => $row['dob'],
            'category_id' => $row['category_id'],
            'trans_no' => $row['trans_no'],
            'created_at' => $row['created_at'],
            'updated_at' => $row['updated_at'],

        ]);
    }
    }

    // public function rules(): array{
    //     return [
    //         '*.phone' => ['unique:clients']
    //     ];
    // }

    public function uniqueBy()
    {
        return 'phone';
    }

    public function onError(Throwable $e)
    {
        
    }
    public function onFailure(ValidatorsFailure ...$failures)
    {
        
    }

    public function batchSize(): int
    {
        return 1000;
    }
}
