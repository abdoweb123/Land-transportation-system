<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestBus;
use App\Models\Bank;
use App\Models\Bus;
use App\Models\BusAttachments;
use App\Models\BusModel;
use App\Models\BusOwner;
use App\Models\BusType;
use App\Models\Driver;
use App\Models\InsuranceCompany;
use App\Models\Seat;
use Illuminate\Http\Request;
use ZipStream\File;

class BusController extends Controller
{

    /*** index function ***/
    public function index()
    {
        $buses = Bus::latest()->paginate(page);
        $busTypes = BusType::where('active',1)->get();
        return view('pages.Buses.index',compact('buses','busTypes'));
    }




    /*** create function ***/
    public function create()
    {
        $busTypes = BusType::where('active',1)->select('id','name')->get();
        $busModels = BusModel::where('active',1)->select('id','name')->get();
        $busOwners = BusOwner::where('active',1)->select('id','name')->get();
        $insuranceCompanies = InsuranceCompany::where('active',1)->select('id','name')->get();
        $banks = Bank::where('active',1)->select('id','name')->get();
        $drivers = Driver::where('active',1)->select('id','name')->get();
        return view('pages.Buses.create',compact('busTypes','busModels','busOwners','insuranceCompanies','banks','drivers'));
    }



    /*** edit function ***/
    public function edit(Bus $bus)
    {
        $busTypes = BusType::where('active',1)->select('id','name')->get();
        $busModels = BusModel::where('active',1)->select('id','name')->get();
        $busOwners = BusOwner::where('active',1)->select('id','name')->get();
        $insuranceCompanies = InsuranceCompany::where('active',1)->select('id','name')->get();
        $banks = Bank::where('active',1)->select('id','name')->get();
        $drivers = Driver::where('active',1)->select('id','name')->get();
        return view('pages.Buses.edit',compact('bus','busTypes','busModels','busOwners','insuranceCompanies','banks','drivers'));
    }



    /*** show function ***/
    public function show(Bus $bus)
    {
        $busTypes = BusType::where('active',1)->select('id','name')->get();
        $busModels = BusModel::where('active',1)->select('id','name')->get();
        $busOwners = BusOwner::where('active',1)->select('id','name')->get();
        $insuranceCompanies = InsuranceCompany::where('active',1)->select('id','name')->get();
        $banks = Bank::where('active',1)->select('id','name')->get();
        $drivers = Driver::where('active',1)->select('id','name')->get();
        return view('pages.Buses.show',compact('bus','busTypes','busModels','busOwners','insuranceCompanies','banks','drivers'));
    }



    /*** store function ***/
    public function store(RequestBus $request)
    {
        $bus = new Bus();
        $bus->code = $request->code;
        $bus->name = $request->name;
        $bus->chassis = $request->chassis;
        $bus->motor_number = $request->motor_number;
        $bus->busModel_id = $request->busModel_id;
        $bus->busOwner_id = $request->busOwner_id;
        $bus->insuranceCompany_id = $request->insuranceCompany_id;
        $bus->bank_id = $request->bank_id;
        $bus->busType_id = $request->busType_id;
        $bus->driver_id = $request->driver_id;
        $bus->licenceStart = $request->licenceStart;
        $bus->licenceEnd = $request->licenceEnd;
        $bus->taxesStart = $request->taxesStart;
        $bus->taxesEnd = $request->taxesEnd;
        $bus->driverLicenceStart = $request->driverLicenceStart;
        $bus->driverLicenceEnd = $request->driverLicenceEnd;
        $bus->admin_id = auth('admin')->id();
        $bus->active = 1;
        $bus->save();


        if ($request->hasFile('documents'))
        {
            foreach ($request->file('documents') as $file)
            {
                $name = $file->getClientOriginalName();

                $fileName = time() . rand(1,20000). uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path().'/assets/images/busDocuments',$fileName);
                $documentsFile[] = $fileName;


                // insert in busAttachments table
                $busAttachments= new BusAttachments();
                $busAttachments->name = $name;
                $busAttachments->fileName = $fileName;
                $busAttachments->bus_id = $bus->id;
                $busAttachments->admin_id = auth('admin')->id();
                $busAttachments->active = 1;
                $busAttachments->save();
            }
        }


        return redirect()->route('buses.index')->with('alert-success','تم حفظ البيانات بنجاح');
    }



    /*** update function ***/
    public function update(RequestBus $request, Bus $bus)
    {
        $bus->code = $request->code;
        $bus->name = $request->name;
        $bus->chassis = $request->chassis;
        $bus->motor_number = $request->motor_number;
        $bus->busModel_id = $request->busModel_id;
        $bus->busOwner_id = $request->busOwner_id;
        $bus->insuranceCompany_id = $request->insuranceCompany_id;
        $bus->bank_id = $request->bank_id;
        $bus->busType_id = $request->busType_id;
        $bus->driver_id = $request->driver_id;
        $bus->licenceStart = $request->licenceStart;
        $bus->licenceEnd = $request->licenceEnd;
        $bus->taxesStart = $request->taxesStart;
        $bus->taxesEnd = $request->taxesEnd;
        $bus->driverLicenceStart = $request->driverLicenceStart;
        $bus->driverLicenceEnd = $request->driverLicenceEnd;
        $bus->admin_id = auth('admin')->id();
        $bus->active = $request->active;
        $bus->update();

        return redirect()->route('buses.index')->with('alert-info','تم تعديل البيانات بنجاح');
    }



    /*** showBusSeats function  ***/
    public function showBusSeats($id)
    {
        $busType_id = Bus::findOrFail($id)->busType->id;
        $busType = Bus::findOrFail($id)->busType;
        $seats = Seat::where('active',1)->where('busType_id',$busType_id)->get();
        return view('pages.Buses.show_bus_seats',compact('seats','busType'));
    }



    /*** downloadFile function  ***/
    public function downloadFile($id)
    {
        $attachment = BusAttachments::find($id);

        $myFile = public_path('assets/images/busDocuments/'.$attachment->fileName);
        return response()->download($myFile);
    }




    /*** soft_delete_bus_attachment Function ***/
    public function soft_delete_bus_attachment(Request $request)
    {
        // soft delete in database
        BusAttachments::where('id',$request->id)->delete();
        return redirect()->back()->with('alert-danger','تم حذف البيانات بنجاح');
    }



    /*** delete from database Function ***/
    public function force_delete_bus_attachment(Request $request)
    {
        // Delete in database
        \Illuminate\Support\Facades\File::delete('assets/images/busDocuments/'.$request->fileName);
        BusAttachments::query()->where('id',$request->id)->forceDelete();

        return redirect()->back()->with('alert-danger','تم حذف البيانات بنجاح');
    }



    /*** Upload_attachment Function ***/
    public function Upload_bus_attachment(Request $request)
    {
//        return $request;
        if ($request->hasFile('documents'))
        {
            foreach ($request->file('documents') as $file)
            {
                $name = $file->getClientOriginalName();

                $fileName = time() . rand(1,20000). uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path().'/assets/images/busDocuments',$fileName);
                $documentsFile[] = $fileName;


                // insert in busAttachments table
                $busAttachments= new BusAttachments();
                $busAttachments->name = $name;
                $busAttachments->fileName = $fileName;
                $busAttachments->bus_id = $request->bus_id;
                $busAttachments->admin_id = auth('admin')->id();
                $busAttachments->active = 1;
                $busAttachments->save();
            }
        }

        return redirect()->back()->with('alert-success','تم إضافة البيانات بنجاح');

    }



    /*** destroy function ***/
    public function destroy(Bus $bus)
    {

        $seat_id = Seat::where('bus_id',$bus->id)->pluck('bus_id');

        if($seat_id->count() == 0)
        {
            $bus = Bus::findOrFail($bus->id)->delete();
            return redirect()->route('buses.index')->with('alert-danger','تم حذف البيانات بنجاح');
        }
        else{
            return redirect()->route('cities.index')->with('alert-danger','حدث خطأ ما أثناء عملية الحذف');
        }

    }



} //end of class
