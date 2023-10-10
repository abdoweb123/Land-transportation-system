<?php

namespace App\Http\Controllers;

use App\Http\Requests\DriverStoreRequest;
use App\Http\Requests\DriverUpdateRequest;
use App\Models\Driver;
use App\Models\DriverAttachments;
use App\Models\Licence;
use App\Models\Office;
use Faker\Core\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DriverController extends Controller
{
    /*** get all drivers ***/
    public function getAllDrivers()
    {
        $drivers = Driver::latest()->paginate(page);
        return view('pages.Drivers.index',compact('drivers'));
    }



    /*** createPage ***/
    public function create_driver_page()
    {
        $offices = Office::where('active',1)->select('id','name')->get();
        $licences = Licence::where('active',1)->select('id','name')->get();
        return view('pages.Drivers.create',compact('offices','licences'));
    }



    /*** editPage ***/
    public function edit_driver_page($id)
    {
        $driver = Driver::findOrFail($id);
        $offices = Office::where('active',1)->select('id','name')->get();
        $licences = Licence::where('active',1)->select('id','name')->get();
        return view('pages.Drivers.edit',compact('offices','licences','driver'));
    }



    /*** create drivers ***/
    public function create(DriverStoreRequest $request)
    {
        $data = $request->all();
        if( $image = $request->file('image'))
        {
            $path = 'assets/images/drivers/';
            $photo = time() . rand(1,20000). uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move($path,$photo);
            $data['image'] = "$photo";
        }


        $driver = new Driver();
        $driver->name = $request['name'];
        $driver->email = $request['email'];
        $driver->mobile = $request['mobile'];
        $driver->image = $data['image'];
        $driver->nationalId = $data['nationalId'];
        $driver->licence_end = $data['licence_end'];
        $driver->taxes_end = $data['taxes_end'];
        $driver->admin_id = auth('admin')->id();
        $driver->licenceType_id = $request['licenceType_id'];
        $driver->office_id = $request['office_id'];
        $driver->password = Hash::make($request['password']);
        $driver->title = $request['title'];
        $driver->role = $request['role'];
        $driver->email_verified_at = $request['email_verified_at'];
        $driver->fcm_token = $request['fcm_token'];
        $driver->bio = $request['bio'];
        $driver->balance = $request['balance'];
        $driver->real_balance = $request['real_balance'];
        $driver->percentage = $request['percentage'];
        $driver->manager = $request['manager'];
        $driver->active = 1;
        $driver->save();


        if ($request->hasFile('documents'))
        {
            foreach ($request->file('documents') as $file)
            {
                $name = $file->getClientOriginalName();

                $fileName = time() . rand(1,20000). uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path().'/assets/images/driverDocuments',$fileName);
                $documentsFile[] = $fileName;


                // insert in busAttachments table
                $busAttachments= new DriverAttachments();
                $busAttachments->name = $name;
                $busAttachments->fileName = $fileName;
                $busAttachments->driver_id = $driver->id;
                $busAttachments->admin_id = auth('admin')->id();
                $busAttachments->active = 1;
                $busAttachments->save();
            }
        }


        return redirect()->route('getAllDrivers')->with('alert-success','تم إضافة المستخدم بنجاح');
    }



    /*** update drivers ***/
    public function update(DriverUpdateRequest $request)
    {
        $data = $request->all();
        $driver = Driver::findOrFail($request->id);

        if( $image = $request->file('image'))
        {
            $path = 'assets/images/drivers/';
            $photo = time() . rand(1,20000). uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move($path,$photo);
            $data['image'] = "$photo";
        }else{
            $data['image'] = $driver->image;
        }


        if ($request->password !== $driver->password)
        {
            $driver->password = Hash::make($request['password']);
        }


        $driver->name =  $request['name'];
        $driver->email =  $request['email'];
        $driver->mobile =  $request['mobile'];
        $driver->image =  $data['image'];
        $driver->admin_id =  auth('admin')->id();
        $driver->office_id =  $request['office_id'];
        $driver->title =  $request['title'];
        $driver->role =  $request['role'];
        $driver->email_verified_at =  $request['email_verified_at'];
        $driver->fcm_token =  $request['fcm_token'];
        $driver->bio =  $request['bio'];
        $driver->balance =  $request['balance'];
        $driver->real_balance =  $request['real_balance'];
        $driver->percentage =  $request['percentage'];
        $driver->manager =  $request['manager'];
        $driver->update();


        return redirect()->route('getAllDrivers')->with('alert-success','تم تحديث بيانات المستخدم بنجاح');
    }



    /*** show function ***/
    public function show_driver($id)
    {
        $driver = Driver::findOrFail($id);
        $offices = Office::where('active',1)->select('id','name')->get();
        $licences = Licence::where('active',1)->select('id','name')->get();
        return view('pages.Drivers.show',compact('offices','licences','driver'));
    }



    /*** Upload_driver_attachment Function ***/
    public function Upload_driver_attachment(Request $request)
    {
        if ($request->hasFile('documents'))
        {
            foreach ($request->file('documents') as $file)
            {
                $name = $file->getClientOriginalName();

                $fileName = time() . rand(1,20000). uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path().'/assets/images/driverDocuments',$fileName);
                $documentsFile[] = $fileName;


                // insert in busAttachments table
                $busAttachments= new DriverAttachments();
                $busAttachments->name = $name;
                $busAttachments->fileName = $fileName;
                $busAttachments->driver_id = $request->driver_id;
                $busAttachments->admin_id = auth('admin')->id();
                $busAttachments->active = 1;
                $busAttachments->save();
            }
        }

        return redirect()->back()->with('alert-success','تم إضافة البيانات بنجاح');

    }



    /*** downloadFile_driver function  ***/
    public function downloadFile_driver($id)
    {
        $attachment = DriverAttachments::find($id);

        $myFile = public_path('assets/images/driverDocuments/'.$attachment->fileName);
        return response()->download($myFile);
    }


    /*** soft_delete_bus_attachment Function ***/
    public function soft_delete_driver_attachment(Request $request)
    {
        // soft delete in database
        DriverAttachments::where('id',$request->id)->delete();
        return redirect()->back()->with('alert-danger','تم حذف البيانات بنجاح');
    }



    /*** delete from database Function ***/
    public function force_delete_driver_attachment(Request $request)
    {
        // Delete in database
        \Illuminate\Support\Facades\File::delete('assets/images/driverDocuments/'.$request->fileName);
        DriverAttachments::query()->where('id',$request->id)->forceDelete();

        return redirect()->back()->with('alert-danger','تم حذف البيانات بنجاح');
    }



    /*** create drivers ***/
    public function delete(Request $request)
    {
        $driver = Driver::findOrFail($request->id);
        $image_path = 'assets/images/drivers/'.$driver->image;

        if (file_exists($image_path))
        {
            @unlink($image_path);
        }

        $driver->delete();
        return redirect()->back()->with('alert-success','تم حذف المستخدم بنجاح');
    }


} //end of class
