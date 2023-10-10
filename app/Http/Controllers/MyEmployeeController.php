<?php

namespace App\Http\Controllers;

use App\Http\Requests\MyEmployeeRequest;
use App\Imports\EmployeeImport;
use App\Models\Department;
use App\Models\EmployeeJob;
use App\Models\MyEmployee;
use App\Models\Office;
use App\Models\Station;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class MyEmployeeController extends Controller
{

    /*** index function  ***/
    public function index()
    {
        $data['myEmployees']= MyEmployee::latest()->paginate(page);

        return view('pages.MyEmployees.index', compact('data'));
    }



    /*** create function  ***/
    public function create()
    {
        $data['offices'] = Office::where('active',1)->select('id','name')->get();
        $data['stations'] = Station::where('active',1)->select('id','name')->get();
        $data['employeeJobs'] = EmployeeJob::where('active',1)->select('id','name')->get();
        $data['departments'] = Department::where('active',1)->select('id','name')->get();
        return view('pages.MyEmployees.create', compact('data'));
    }



    /*** store function  ***/
    public function store(MyEmployeeRequest $request)
    {
        $myEmployee = new MyEmployee();
        $myEmployee->oracle_id = $request->oracle_id;
        $myEmployee->office_id = $request->office_id;
        $myEmployee->collectionPoint_id = $request->collectionPoint_id;
        $myEmployee->employeeJob_id = $request->employeeJob_id;
        $myEmployee->department_id = $request->department_id;
        $myEmployee->address = $request->address;
        $myEmployee->gender = $request->gender;
        $myEmployee->name = $request->name;
        $myEmployee->phone = $request->phone;
        $myEmployee->email = $request->email;
        $myEmployee->password = Hash::make($request->password);
        $myEmployee->admin_id = auth('admin')->id();
        $myEmployee->active = 1;
        $myEmployee->save();

        return redirect()->route('myEmployees.index')->with('alert-success','تم حفظ البيانات بنجاح');
    }



    /*** edit function  ***/
    public function edit(MyEmployee $myEmployee)
    {
        $data['offices'] = Office::where('active',1)->select('id','name')->get();
        $data['stations'] = Station::where('active',1)->select('id','name')->get();
        $data['employeeJobs'] = EmployeeJob::where('active',1)->select('id','name')->get();
        $data['departments'] = Department::where('active',1)->select('id','name')->get();
        return view('pages.MyEmployees.edit', compact('data','myEmployee'));
    }



    /*** update function  ***/
    public function update(MyEmployeeRequest $request, MyEmployee $myEmployee)
    {


        if ($request->password === $myEmployee->password)
        {
            $myEmployee->oracle_id = $request->oracle_id;
            $myEmployee->office_id = $request->office_id;
            $myEmployee->collectionPoint_id = $request->collectionPoint_id;
            $myEmployee->employeeJob_id = $request->employeeJob_id;
            $myEmployee->department_id = $request->department_id;
            $myEmployee->address = $request->address;
            $myEmployee->gender = $request->gender;
            $myEmployee->name = $request->name;
            $myEmployee->phone = $request->phone;
            $myEmployee->email = $request->email;
            $myEmployee->admin_id = auth('admin')->id();
            $myEmployee->active =$request->active;
            $myEmployee->update();
        }
        else {
            $myEmployee->oracle_id = $request->oracle_id;
            $myEmployee->office_id = $request->office_id;
            $myEmployee->collectionPoint_id = $request->collectionPoint_id;
            $myEmployee->employeeJob_id = $request->employeeJob_id;
            $myEmployee->department_id = $request->department_id;
            $myEmployee->address = $request->address;
            $myEmployee->gender = $request->gender;
            $myEmployee->phone = $request->phone;
            $myEmployee->email = $request->email;
            $myEmployee->password = Hash::make($request->password);
            $myEmployee->admin_id = auth('admin')->id();
            $myEmployee->active =$request->active;
            $myEmployee->update();
        }



        return redirect()->route('myEmployees.index')->with('alert-success','تم تحديث البيانات بنجاح');
    }



    /*** destroy function  ***/
    public function destroy(MyEmployee $myEmployee)
    {
        $myEmployee->delete();
        return redirect()->back()->with('alert-info','تم حذف البيانات بنجاح');
    }



    /*** get excel function  ***/
    public function getExcel()
    {
        return view('pages.MyEmployees.excel');
    }



    /*** import excel function  ***/
    public function import(Request $request)
    {
        $file = $request->file('excel');

            DB::table('excel_employees')->truncate();

        Excel::import(new EmployeeImport(),$file);

        return redirect()->back()->with('alert-info','تم إضافة البيانات بنجاح');
    }

} //end of class


