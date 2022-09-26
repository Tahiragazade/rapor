<?php

namespace App\Imports;

use App\Models\Rapor;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Calculation\DateTime;

class RaporImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if(is_string($row[11])){

        }
        else{
            if($row[6]==null){
                $newDate=null;
            }
            else{
                $date =  ($row[6] - 25569) * 86400;
                $newDate=Carbon::parse($date);
            }

            return new Rapor([

                'wo'=> $row[0],
                'user'=> $row[2],
                'parts_cost'=> $row[11],
                'payment_type'=> $row[12],
                'work_date'=>$newDate,
            ]);
        }
//        return new Rapor([
//
//            'wo'=> $row[0],
//            'user'=> $row[2],
//            'parts_cost'=> $row[11],
//            'payment_type'=> $row[12],
//            'work_date'=> $row[6],
//        ]);
    }
}
