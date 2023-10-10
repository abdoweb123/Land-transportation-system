<?php

namespace App\Http\Controllers;

use App\Http\Requests\TripDataRequest;
use App\Models\BusType;
use App\Models\Degree;
use App\Models\Line;
use App\Models\PaymentMethod;
use App\Models\PaymentMethodTrip;
use App\Models\TripData;
use App\Models\TripDegree;
use App\Models\TripStation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TripDataController extends Controller
{

    /*** index function  ***/
    public function index()
    {
        $tripData = TripData::with('tripDegrees')->latest()->paginate(page);
        $tripDegrees = TripDegree::select('degree_id')->get();
        $busTypes = BusType::where('active',1)->whereHas('seats')->select('id','name')->get();
        $degrees = Degree::where('active',1)->select('id','name')->get();

        return view('pages.TripData.index', compact('tripData','busTypes','degrees','tripDegrees'));
    }



    /*** store function  ***/
    public function store(TripDataRequest $request)
    {
//        TripData::create([
//            'name'=>$request->name,
//            'busType_id'=>$request->busType_id,
//            'admin_id'=>auth('admin')->id(),
//            'notes'=>$request->notes,
//        ]);

           $tripData = new TripData();
           $tripData->name = $request->name;
           $tripData->busType_id = $request->busType_id;
           $tripData->admin_id = auth('admin')->id();
           $tripData->active = 1;
           $tripData->notes = $request->notes;
           $tripData->save();



         foreach ($request->degrees as $degree)  // 2 , 3 , 4
         {
             TripDegree::create([
                 'admin_id'=>auth('admin')->id(),
                 'tripData_id'=>$tripData->id,
                 'degree_id'=>$degree,
             ]);
         }


        return redirect()->route('tripData.index')->with('alert-success','تم تسجيل البيانات بنجاح');
    }



    /*** update function  ***/
    public function update(Request $request)
    {
        $tripData = TripData::findOrFail($request->id);

        // تعديل بيانات الرحلة
        $tripData->update([
            'name'=>$request->name,
            'busType_id'=> $request->busType_id,
            'admin_id'=> auth('admin')->id(),
            'active'=> $request->active,
            'notes'=>$request->notes,
        ]);


        // شوف لو في درجات ولا لا
        if ($request->degrees != '')
        {
            // إنشاء درجات جديدة
            foreach ($request->degrees as $degree)  // 2 , 3 , 4
            {

                $tripDegrees = TripDegree::where('tripData_id',$request->id)->pluck('degree_id')->toArray();   // [2,3,4]

                if (!in_array($degree,$tripDegrees))     // قم بإضافة الدرجات غير الموجودة فقط
                {
                    TripDegree::create([
                        'admin_id'=>auth('admin')->id(),
                        'tripData_id'=>$request->id,
                        'degree_id'=>$degree,
                    ]);



                 /*  إضافة الدرجات الجديدة للخطوط الموجودة  */

                    $tripData_id = $request->id;


                    // شوف لو في محطات موجودة
                    if (TripStation::where('tripData_id',$tripData_id)->pluck('id') !== '[]')
                    {
                        $tripStations = TripStation::where('tripData_id',$tripData_id)->pluck('id');


                        foreach ($tripStations as $tripStation)
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


                                // لو لم تجد خط من محطة الانطلاق لمحطة الوصول بنفس الدرجة قم بتنفيذ الكود التالي ( إنشاء درجات جديدة للخط )
                                if ( DB::table('lines')->where('stationFrom_id',$getStationFrom_id)->where('stationTo_id',$stationTo_id)->where('degree_id',$degree)->pluck('id') == '[]')
                                {
                                    // Not created
                                    // حتي لا يكون هناك خط بين المحطة ونفسها --- حتي لا يبدأ الخط بمحطة نزول
                                    if ($getStationFromType != 2 && $getStationFrom_id != $getStationTo_id)
                                    {

                                        $RankOfStationFrom = TripStation::where('id',$getStationFrom_id)->pluck('rank');
                                        $RankOfStationTo   = TripStation::where('id',$getStationTo_id)->pluck('rank');

                                        if ($RankOfStationTo > $RankOfStationFrom)
                                        {
                                            Line::create([
                                                'tripData_id'=>$tripData_id,
                                                'admin_id'=>auth('admin')->id(),
                                                'degree_id'=>$degree,
                                                'stationFrom_id'=>$getStationFrom_id,
                                                'stationTo_id'=>$getStationTo_id,
                                                'active'=>1,
                                            ]);
                                        }

                                    }

                                }

                                if ($getStationFromType == 2 && $getStationFrom_id != $getStationTo_id)
                                {
                                    Line::where('stationFrom_id',$getStationFrom_id)->forceDelete();
                                }

                            }
                        }

                        /*  إضافة الدرجات الجديدة للخطوط الموجودة  */
                    }
                }
            }
        }

        return redirect()->back()->with('alert-success','تم تحديث البيانات بنجاح');
    }



    /*** update function  ***/
    public function update_paymentMethods(Request $request)
    {
        if (isset($request->paymentMethods))
        {
            foreach ($request->paymentMethods as $paymentMethod)
            {

                $triPaymentMethods = PaymentMethodTrip::where('tripData_id',$request->id)->pluck('paymentMethod_id')->toArray();   // [2,3,4]

                if (!in_array($paymentMethod,$triPaymentMethods))     // قم بإضافة وسائل الدفع غير الموجودة فقط
                {
                    $paymentMethodTrip = new PaymentMethodTrip();
                    $paymentMethodTrip->tripData_id = $request->id;
                    $paymentMethodTrip->paymentMethod_id = $paymentMethod;
                    $paymentMethodTrip->admin_id = auth('admin')->id();
                    $paymentMethodTrip->save();
                }

            }

            return redirect()->back()->with('alert-success','تم تسجيل البيانات بنجاح');
        }
        else{
            return redirect()->back()->with('alert-danger','برجاء اختيار وسيلة دفع');
        }

    }



    /*** destroy function  ***/
    public function destroy(Request $request)
    {
        $tripData = TripData::findOrFail($request->id)->delete();
        return redirect()->route('tripData.index')->with('alert-success','تم حذف البيانات بنجاح');
    }


} //end of class
