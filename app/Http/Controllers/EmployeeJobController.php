<?php

namespace App\Http\Controllers;

use App\Models\EmployeeJob;
use Illuminate\Http\Request;

class EmployeeJobController extends Controller
{

    /*** index function  ***/
    public function index()
    {
        $employeeJobs = EmployeeJob::latest()->paginate(page);
        return view('pages.EmployeeJobs.index', compact('employeeJobs'));
    }



    /*** store function  ***/
    public function store(Request $request)
    {
        $rules = [
            'name'=>'required',
        ];
        $messages = [
            'name.required'=>'اسم الوظيفة مطلوب',
        ];

        $this->validate($request,$rules,$messages);

        $employeeJob = new EmployeeJob();
        $employeeJob->name = $request['name'];
        $employeeJob->admin_id = auth('admin')->id();
        $employeeJob->active = 1;
        $employeeJob->save();
        return redirect()->route('employeeJobs.index')->with('alert-success','تم حفظ البيانات بنجاح');
    }



    /*** update function  ***/
    public function update(Request $request, EmployeeJob $employeeJob)
    {
        $rules = [
            'name'=>'required',
        ];
        $messages = [
            'name.required'=>'اسم الوظيفة مطلوب',
        ];

        $this->validate($request,$rules,$messages);

        $employeeJob->name = $request['name'];
        $employeeJob->admin_id = auth('admin')->id();
        $employeeJob->active = $request['active'];
        $employeeJob->update();
        return redirect()->route('employeeJobs.index')->with('alert-success','تم تحديث البيانات بنجاح');

    }



    /*** destroy function  ***/
    public function destroy(EmployeeJob $employeeJob)
    {
        $employeeJob->delete();
        return redirect()->route('employeeJobs.index')->with('alert-success','تم حذف البيانات بنجاح');
    }

} //end of class
