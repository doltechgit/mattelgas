<?php

namespace App\Exports;

use App\Models\Client;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ClientExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Client::all();
    }

    public function headings(): array
    {
        return [
            'id',
            'name',
            'phone',
            'email',
            'address',
            'dob',
            'category_id',
            'trans_no',
            'created_at',
            'updated_at'
        ];
    }
}
