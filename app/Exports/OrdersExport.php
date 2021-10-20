<?php

namespace App\Exports;

// use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

use App\Models\Order;

class OrdersExport implements FromQuery, WithHeadings
{
    use Exportable;

    public function __construct()
    {
        $this->year = 2020;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    //     return Order::all();
    // }

     public function query()
    {   
        
        return Order::query()->select('id', 'service_name', 'technician_id','created_at','updated_at')->whereYear('updated_at', $this->year);
    }

    public function headings() : array{
        return [
            'Id',
            'Service Name',
            'Technician Id',
            'Created At',
            'Updated At',
        ];
    }
}
