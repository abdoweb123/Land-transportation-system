<?php

namespace App\Http\Controllers;

use App\Http\Requests\LinesRequest;
use App\Models\Degree;
use App\Models\Line;
use App\Models\Station;
use App\Models\TripData;
use App\Models\TripDegree;
use App\Models\TripStation;
use Dotenv\Parser\Lines;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LineController extends Controller
{

    /*** getAllLinesOfTrip ***/
    public function getAllLinesOfTrip($tripData_id)
    {
        $data['tripData'] = TripData::find($tripData_id);

        $data['lines'] = Line::where('lines.tripData_id', $tripData_id)->where('lines.degree_id','!=',null)
            ->orderBy('lines.id')->orderBy('lines.degree_id')->select('lines.*')->paginate(100);

        return view('pages.TripData.Lines.getLinesOfTrip', compact('data'))->with('alert-success','تم تسجيل البيانات بنجاح');
    }



    /*** createLinesOfTrip function To give it degree ***/
    public function getUndegreededLinesOfTrip($tripData_id)
    {

//        $data['tripData'] = TripData::find($tripData_id);
//
//        // الدرجات الموجودة في ال lines
//       $degreesOfLines = Line::where('tripData_id',$tripData_id)->pluck('degree_id')->toArray();  // array
//
//        // الدرجات الموجودة في ال TripDegree
//       $tripDegrees = TripDegree::where('tripData_id',$tripData_id)->pluck('degree_id');   // 2341
//
//
//        foreach ($tripDegrees as $degree)
//        {
//
////              $mainDegree = Degree::where('id',$degree)->first()->lines;
////
////              $numMainDegree  =  count($mainDegree);   // 14
//
//            if (!in_array($degree,$degreesOfLines))
//            {
////               echo  $degree;     // 1 4
//
//              return  $degreesOfLines = Line::where('tripData_id',$tripData_id)->get();
//
//
//            }
//        }

        $data['tripData'] = TripData::find($tripData_id);

        $data['lines'] = Line::where('lines.tripData_id', $tripData_id)->where('lines.degree_id',null)
            ->orderBy('lines.degree_id')->select('lines.*')->paginate(25);

        return view('pages.TripData.Lines.getUndegreedLinesOfTrip', compact('data'))->with('alert-success','تم تسجيل البيانات بنجاح');
    }



     /*** createLinesOfTrip function  ***/
    public function createLinesOfTrip(Request $request)
    {

        $tripData_id = $request->tripData_id;


        if ($request->tripStations != '' )
        {

            foreach ($request->tripStations as $tripStation)
            {
                $stations = TripStation::where('id',$tripStation); //7
                $rank =  $stations->select('rank')->pluck('rank'); //15
                $ranks[] = $rank;
            }

            sort($ranks);


            foreach ($ranks as $row)
            {
                foreach ($row as $k){
                    $newRanks[] = $k;
                }
            }


            // 0 , 1 , 2                                                      2,6    2,10   6,10
            for ($i=0; $i<count($newRanks); $i++){   //  15 , 20 , 25  ==>>  15,20  15,25  20,25

                $ranks1 = $newRanks;

                $x = $i;
                for ($x++; $x<count($newRanks); $x++)
                {

                    // $getStationFrom_id
                    $rankStationFrom = $ranks1[$i];
                    $stationFrom_id = TripStation::where('tripData_id',$tripData_id)->where('rank',$rankStationFrom)->pluck('id');
                    $getStationFrom_id = str_replace(array('[',']'), '',$stationFrom_id);

                    // $getStationFrom_id type
                    $stationFromType = TripStation::where('id',$getStationFrom_id)->pluck('type');
                    $getStationFromType = str_replace(array('[',']'), '',$stationFromType);



                    // $getStationTo_id
                    $rankStationTo = $newRanks[$x];
                    $stationTo_id = TripStation::where('tripData_id',$tripData_id)->where('rank',$rankStationTo)->pluck('id');
                    $getStationTo_id = str_replace(array('[',']'), '',$stationTo_id);

                    // $getStationTo_id type
                    $stationToType = TripStation::where('id',$getStationTo_id)->pluck('type');
                    $getStationToType = str_replace(array('[',']'), '',$stationToType);


                    // لو لم تجد خطا من محطة الانطلاق لمحطة الوصول قم بتنفيذ الكود التالي ( إنشاء خط جديد )
                    if ( DB::table('lines')->where('stationFrom_id',$getStationFrom_id)->where('stationTo_id',$stationTo_id)->pluck('id') == '[]')
                    {
                        // Not created
                        // حتي لا يكون هناك خط بين المحطة ونفسها --- حتي لا يبدأ الخط بمحطة نزول
                        if ($getStationFromType != 2 && $getStationFrom_id != $getStationTo_id)
                        {
                            $StationFromWithType_id = $getStationFrom_id;

                            $from_id = TripStation::where('id',$StationFromWithType_id)->pluck('station_id');
                            $getFrom_id = str_replace(array('[',']'), '',$from_id);

                            $to_id = TripStation::where('id',$getStationTo_id)->pluck('station_id');
                            $getTo_id = str_replace(array('[',']'), '',$to_id);

                            Line::create([
                                'tripData_id'=>$tripData_id,
                                'admin_id'=>auth('admin')->id(),
                                'stationFrom_id'=>$StationFromWithType_id,
                                'stationTo_id'=>$getStationTo_id,
                                'from_id'=>$getFrom_id,
                                'to_id'=>$getTo_id,
                                'active'=>1,
                            ]);

                        }

                    }

                    if ($getStationFromType == 2 && $getStationFrom_id != $getStationTo_id)
                    {
                        Line::where('stationFrom_id',$getStationFrom_id)->forceDelete();
                    }

                }
            }
        }
         else{
             return redirect()->back()->with('alert-danger','لا يوجد بيانات لحفظها');
         }


        return redirect()->route('getUndegreededLines',$tripData_id);
    }



    /***  add degrees to lines  function  ***/
    public function addDegreesToLines(Request $request)
    {

//        return $request;


        $lines = DB::table('lines')->where('tripData_id',$request->tripData_id)
            ->where('lines.degree_id',null)->get();

        $numOfLines = count($lines);       //  8

        if ($numOfLines == 0){
            return redirect()->back()->with('alert-danger','لا يوجد بيانات لحفظها');
        }

        $numOfDegrees =  $request->degrees;      // 3

        $total = $numOfLines * $numOfDegrees;   // 24

        $updateLines = $total / $numOfDegrees;  // 8

        $createLines = $total - $updateLines;   // 16






        //  update existed lines
        for ($i=0; $i<$updateLines; $i++)
        {

           $id = $request->id[$i];          // ids --> 17 , 18 , 19 , 20 , 21 , 22 , 23 , 24
           $degree_id = $request->degree_id[$i];
           $priceGo = $request->priceGo[$i];
           $priceBack = $request->priceBack[$i];
           $priceForeignerGo = $request->priceForeignerGo[$i];
           $priceForeignerBack = $request->priceForeignerBack[$i];
           $active = $request->active[$i];
           $cancelFee = $request->cancelFee[$i];
           $editFee = $request->editFee[$i];

            $line = Line::find($id);

                $line->update([
                    'degree_id'=>$degree_id,
                    'priceGo'=>$priceGo,
                    'priceBack'=>$priceBack,
                    'priceForeignerGo'=>$priceForeignerGo,
                    'priceForeignerBack'=>$priceForeignerBack,
                    'active'=>$active,
                    'cancelFee'=>$cancelFee,
                    'editFee'=>$editFee,
                ]);
        }



        // create new lines

        for ($i=$updateLines; $i<$total; $i++)
        {

            $degree_id = $request->degree_id[$i];
            $priceGo = $request->priceGo[$i];
            $priceBack = $request->priceBack[$i];
            $priceForeignerGo = $request->priceForeignerGo[$i];
            $priceForeignerBack = $request->priceForeignerBack[$i];
            $active = $request->active[$i];
            $cancelFee = $request->cancelFee[$i];
            $editFee = $request->editFee[$i];
            $stationFrom_id = $request->stationFrom_id[$i];
            $stationTo_id = $request->stationTo_id[$i];
            $tripData_id = $request->tripData_id;


            $from_id = TripStation::where('id',$stationFrom_id)->pluck('station_id');
            $getFrom_id = str_replace(array('[',']'), '',$from_id);

            $to_id = TripStation::where('id',$stationTo_id)->pluck('station_id');
            $getTo_id = str_replace(array('[',']'), '',$to_id);

            Line::create([
                'admin_id'=>auth('admin')->id(),
                'stationFrom_id'=>$stationFrom_id,
                'stationTo_id'=>$stationTo_id,
                'from_id'=>$getFrom_id,
                'to_id'=>$getTo_id,
                'tripData_id'=>$tripData_id,
                'degree_id'=>$degree_id,
                'priceGo'=>$priceGo,
                'priceBack'=>$priceBack,
                'priceForeignerGo'=>$priceForeignerGo,
                'priceForeignerBack'=>$priceForeignerBack,
                'active'=>$active,
                'cancelFee'=>$cancelFee,
                'editFee'=>$editFee,
            ]);

        }



        return redirect()->back()->with('alert-success','تم تحديث البيانات بنجاح');
    }



    /***  update lines information  ***/
    public function updateLines(Request $request)
    {

        $lines = DB::table('lines')->where('tripData_id',$request->tripData_id)
            ->where('lines.degree_id','!=',null)->get();

        $numOfLines = count($lines);       //  8

        if ($numOfLines == 0){
            return redirect()->back()->with('alert-danger','لا يوجد بيانات لحفظها');
        }

        $numOfDegrees =  $request->degrees;      // 3

        $total = $numOfLines * $numOfDegrees;   // 24

        $updateLines = $total / $numOfDegrees;  // 8

        //  update existed lines
        for ($i=0; $i<$updateLines; $i++)
        {

            $id = $request->id[$i];          // ids --> 17 , 18 , 19 , 20 , 21 , 22 , 23 , 24
            $degree_id = $request->degree_id[$i];
            $priceGo = $request->priceGo[$i];
            $priceBack = $request->priceBack[$i];
            $priceForeignerGo = $request->priceForeignerGo[$i];
            $priceForeignerBack = $request->priceForeignerBack[$i];
            $active = $request->active[$i];
            $cancelFee = $request->cancelFee[$i];
            $editFee = $request->editFee[$i];

            $line = Line::find($id);

            $line->update([
                'degree_id'=>$degree_id,
                'priceGo'=>$priceGo,
                'priceBack'=>$priceBack,
                'priceForeignerGo'=>$priceForeignerGo,
                'priceForeignerBack'=>$priceForeignerBack,
                'active'=>$active,
                'cancelFee'=>$cancelFee,
                'editFee'=>$editFee,
            ]);
        }

        return redirect()->back()->with('alert-success','تم تحديث البيانات بنجاح');
    }


} //end of class
