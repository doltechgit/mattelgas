<?php

namespace App\Exports;

use App\Models\Client;
use App\Models\Stock;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class StockReport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('stocks.export', [
            'stocks' => Stock::all()
        ]);
    }
}
