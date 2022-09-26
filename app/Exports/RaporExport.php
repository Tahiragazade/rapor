<?php

namespace App\Exports;

use App\Models\Rapor;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;

class RaporExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Rapor::select([
            'user',
            DB::raw("group_concat(payment_type) as paymentType"),
            DB::raw("group_concat(parts_cost) as partsCost"),
            DB::raw("SUM(parts_cost) as totalCost"),
            'work_date',
        ])
            ->havingRaw('totalCost > 1000')
            ->groupBy('work_date','user')
            ->get();
    }
    public function headings(): array
    {
        return [
            'User Name',
            'Payment Types',
            'Part Costs',
            'Total Costs',
            'Dates',
        ];
    }
}
