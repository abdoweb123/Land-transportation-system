<?php

namespace App\Imports;


use App\Models\ExcelEmployee;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class EmployeeExcel implements ToCollection ,WithHeadingRow
{
//    public $resulttt=[],$infraction_add_count,$infraction_notadd_count,$arr_inf_add=[],$arr_inf_not_add=[];



    public function collection(Collection $rows)
    {
//        DB::beginTransaction();
        try {
            if ($rows) {
                foreach ($rows as $row) {
//                    dd($row);
//                    $data = new ExcelEmployee();
//
//                    $data->name = $row['type_of_vehicle'];
//                    $data->lob = $row['date'];
//                    $data->oracle = $row['start'];
//                    $data->site = $row['route'];
//                    $data->route = $row['direction_collection_points_per_each_vehicle'];
//
//
//                    $data->save();
//                    dd($row['type_of_vehicle']);
                    ExcelEmployee::create([
                        'name' => $row['type_of_vehicle'],
                        'lob' => $row['date'],
                        'oracle' => $row['start'],
                        'site' => $row['route'],
                        'route' => $row['direction_collection_points_per_each_vehicle'],

//                        'cp' => $row['end'],
//                        'gender' => $row['hc'],
//                        'date' => $row['Date'],
//                        'shift' => $row['Shift'],
//                        'start' => $row['START'],
//                        'end' => $row['End'],
                    ]);
                }
            }

        } catch (\Exception $e) {
            $this->message=$e->getMessage();
            return $this->message;
        }
    }
}

















//<?php
//
//namespace App\Imports;
//
//use App\Models\ExcelEmployee;
//use Maatwebsite\Excel\Concerns\ToModel;
//use Maatwebsite\Excel\Concerns\WithHeadingRow;
//use Illuminate\Contracts\Queue\ShouldQueue;
//use Maatwebsite\Excel\Concerns\WithChunkReading;
//use Maatwebsite\Excel\Concerns\WithBatchInserts;
//
//class EmployeeExcel implements  ToCollection ,WithHeadingRow
//{
//    /**
//    * @param array $row
//    *
//    * @return \Illuminate\Database\Eloquent\Model|null
//    */
//    public function model(array $row)
//    {
//        return new ExcelEmployee([

//            'name' => $row['Name'],
//            'lob' => $row['LOB'],
//            'oracle' => $row['Oracle'],
//            'site' => $row['Site'],
//            'route' => $row['ROUTE'],
//            'cp' => $row['CP'],
//            'gender' => $row['GENDER'],
//            'date' => $row['Date'],
//            'shift' => $row['Shift'],
//            'start' => $row['START'],
//            'end' => $row['End'],


//            'name' => $row[0],
//            'lob' => $row[1],
//            'oracle' => $row[2],
//            'site' => $row[3],
//            'route' => $row[4],
//            'cp' => $row[5],
//            'gender' => $row[6],
//            'date' => $row[7],
//            'shift' => $row[8],
//            'start' => $row[9],
//            'end' => $row[10],
//        ]);
//    }
//
//
//    public function chunkSize(): int
//    {
//        return 1000;
//    }
//
//}
