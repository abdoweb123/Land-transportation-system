<?php

namespace App\Imports;


use App\Models\ExcelEmployee;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class EmployeeImport implements ToModel ,WithHeadingRow //, WithChunkReading, ShouldQueue
{

    use Importable;

    public function model(array $row)
    {
//        dd($row);
//        foreach ($row as $item)
//        {
//            if ($item->end == '')
//            {
//                echo $item;
//            }
//        }

        return new ExcelEmployee([
            'name'=>$row['name'],
            'lob'=>$row['lob'],
            'oracle'=>$row['oracle'],
            'site'=>$row['site'],
            'route'=>$row['route'],
            'cp'=>$row['cp'],
            'gender'=>$row['gender'],
            'date'=>$row['date'],
            'shift'=>$row['shift'],
            'start'=>$row['start'],
            'end'=>$row['end'],

        ]);
    }

//    public function chunkSize(): int
//    {
//        return 1000;
//    }


}

