<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportUser;
use App\Exports\ExportUser;
use App\Models\User;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Exception;

class UserController extends Controller
{
    public function importView(Request $request){
        return view('importFile');
    }

    public function import(Request $request){
        // Excel::import(new ImportUser, $request->file('file')->store('files'));
        // return redirect()->back();
        Excel::load( $request->file('file'), function($reader) {

            // Getting all results
            $results = $reader->get();

            // ->all() is a wrapper for ->get() and will work the same
            $results = $reader->all();

        });
    }

    public function exportUsers(Request $request){
        return Excel::download(new ExportUser, 'users.xlsx');
    }
    public function rapor(Request $request){
        $this->validate($request, [
            'file' => 'required|file|mimes:xls,xlsx'
        ]);
        $the_file = $request->file('file');
        try{
            $spreadsheet = IOFactory::load($the_file->getRealPath());
            $sheet        = $spreadsheet->getActiveSheet();
            $row_limit    = $sheet->getHighestDataRow();
            $column_limit = $sheet->getHighestDataColumn();
            $row_range    = range( 2, $row_limit );
            $column_range = range( 'A', $column_limit );
            $startcount = 2;
            $data = array();
            foreach ( $row_range as $row ) {
                $data[] = [
                    'WO' =>$sheet->getCell( 'A' . $row )->getValue(),
                    'LeadTech' => $sheet->getCell( 'C' . $row )->getValue(),
                    'WorkDate' => $sheet->getCell( 'G' . $row )->getValue(),
                    'PartsCost' => $sheet->getCell( 'L' . $row )->getValue(),
                    'PostalCode' => $sheet->getCell( 'M' . $row )->getValue(),
                ];
                $startcount++;
                dd($data);
            }

        } catch (Exception $e) {
            $error_code = $e->errorInfo[1];
            dd($error_code);
            // return back()->withErrors('There was a problem uploading the data!');
        }
        dd("ok");
        // return back()->withSuccess('Great! Data has been successfully uploaded.');

    }
}
