<?php

namespace App\Http\Controllers;

use App\Exports\RaporExport;
use App\Imports\RaporImport;
use App\Models\Rapor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
class RaporController extends Controller
{
    public function import(Request $request){
        $this->validate($request, [
            'file' => 'required|file|mimes:xls,xlsx'
        ]);

         Excel::import(new RaporImport(), $request->file('file')->store('files'));
         return response()->json(['message'=>'ok']);
    }
    public function rapor()
    {
       $rapor=Rapor::select([
           'user',
           DB::raw("group_concat(payment_type) as paymentType"),
           DB::raw("group_concat(parts_cost) as partsCost"),
           DB::raw("SUM(parts_cost) as totalCost"),
           'work_date',
       ])
           ->havingRaw('totalCost > 1000')
        ->groupBy('work_date','user')
        ->get();
       return response()->json(['data'=>$rapor]);
    }
    public function export(Request $request){

            return Excel::download(new RaporExport(), 'rapor.xlsx');


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
