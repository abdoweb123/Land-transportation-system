<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{

    /*** index function  ***/
    public function index()
    {
        $departments = Department::latest()->paginate(page);
        return view('pages.Departments.index', compact('departments'));
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

        $department = new Department();
        $department->name = $request['name'];
        $department->admin_id = auth('admin')->id();
        $department->active = 1;
        $department->save();
        return redirect()->route('departments.index')->with('alert-success','تم حفظ البيانات بنجاح');
    }



    /*** update function  ***/
    public function update(Request $request, Department $department)
    {
        $rules = [
            'name'=>'required',
        ];
        $messages = [
            'name.required'=>'اسم الوظيفة مطلوب',
        ];

        $this->validate($request,$rules,$messages);

        $department->name = $request['name'];
        $department->admin_id = auth('admin')->id();
        $department->active = $request['active'];
        $department->update();
        return redirect()->route('departments.index')->with('alert-success','تم تحديث البيانات بنجاح');

    }



    /*** destroy function  ***/
    public function destroy(Department $department)
    {
        $department->delete();
        return redirect()->route('departments.index')->with('alert-success','تم حذف البيانات بنجاح');
    }

} //end of class
