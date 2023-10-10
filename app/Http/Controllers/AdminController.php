<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminLogin;
use App\Http\Requests\AdminRegister;
use App\Http\Requests\AdminUpdateRequest;
use App\Http\Requests\CreateEmployee;
use App\Http\Requests\RegisterAdminRequest;
use App\Http\Requests\UpdateEmployee;
use App\Models\Admin;
use App\Models\Department;
use App\Models\EmployeeJob;
use App\Models\EmployeeSituation;
use App\Models\Office;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class AdminController
{

    /*** get all ( employees || managers ) ***/
    public function getAllAdmins($id)
    {
        if ($id == 3){
            $employees = Admin::where('type','3')->with('parent')->latest()->paginate(page);
            $offices = Office::where('active',1)->select('id','name')->get();
            return view('pages.Employees.index',compact('employees','offices'));
        }
        elseif($id == 2){
            $managers = Admin::where('type','2')->latest()->paginate(page);
            return view('pages.Managers.index',compact('managers'));
        }
    }



    /*** create admins ( managers ) ***/
    public function create(AdminRegister $request)
    {
        $admin = Admin::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'admin_id' => auth('admin')->id(),
            'type' => $request['type'],
            'active' => 1,
            'office_id' => $request['office_id'],
            'password' => Hash::make($request['password']),
        ]);

        return redirect()->back()->with('alert-success','تم إضافة المستخدم بنجاح');
    }



    /*** create_employee_page ***/
    public function create_employee_page()
    {
        $departments = Department::where('active',1)->select('id','name')->get();
        $employeeJobs = EmployeeJob::where('active',1)->select('id','name')->get();
        $employeeSituations = EmployeeSituation::where('active',1)->select('id','name')->get();
        $offices = Office::where('active',1)->select('id','name')->get();

        return view('pages.Employees.create',compact('departments','employeeSituations','employeeJobs','offices'));
    }



    /*** edit_employee_page ***/
    public function edit_employee_page($id)
    {
        $employee = Admin::findOrFail($id);
        $departments = Department::where('active',1)->select('id','name')->get();
        $employeeJobs = EmployeeJob::where('active',1)->select('id','name')->get();
        $employeeSituations = EmployeeSituation::where('active',1)->select('id','name')->get();
        $offices = Office::where('active',1)->select('id','name')->get();

        return view('pages.Employees.edit',compact('employee','departments','employeeSituations','employeeJobs','offices'));
    }



    /*** show_employee_page ***/
    public function show_employee_page($id)
    {
        $employee = Admin::findOrFail($id);
        $departments = Department::where('active',1)->select('id','name')->get();
        $employeeJobs = EmployeeJob::where('active',1)->select('id','name')->get();
        $employeeSituations = EmployeeSituation::where('active',1)->select('id','name')->get();
        $offices = Office::where('active',1)->select('id','name')->get();

        return view('pages.Employees.show',compact('employee','departments','employeeSituations','employeeJobs','offices'));
    }



    /*** create_employee ***/
    public function create_employee(CreateEmployee $request)
    {
        $employee = new Admin();
        $employee->name = $request['name'];
        $employee->email = $request['email'];
        $employee->type = $request['type'];
        $employee->code = $request['code'];
        $employee->department_id = $request['department_id'];
        $employee->employeeJob_id = $request['employeeJob_id'];
        $employee->employeeSituation_id = $request['employeeSituation_id'];
        $employee->birthdate = $request['birthdate'];
        $employee->appointDate = $request['appointDate'];
        $employee->degree = $request['degree'];
        $employee->office_id = $request['office_id'];
        $employee->password = Hash::make($request['password']);
        $employee->admin_id = auth('admin')->id();
        $employee->active = 1;
        $employee->save();


        return redirect()->route('getAllEmployees',3)->with('alert-success','تم إضافة المستخدم بنجاح');
    }



    /*** update_employee ***/
    public function update_employee(UpdateEmployee $request)
    {
        $employee = Admin::findOrFail($request->id);
        $employee->name = $request['name'];
        $employee->email = $request['email'];
        $employee->code = $request['code'];
        $employee->department_id = $request['department_id'];
        $employee->employeeJob_id = $request['employeeJob_id'];
        $employee->employeeSituation_id = $request['employeeSituation_id'];
        $employee->birthdate = $request['birthdate'];
        $employee->appointDate = $request['appointDate'];
        $employee->degree = $request['degree'];
        $employee->office_id = $request['office_id'];

        if ($request->password !== $employee->password)
        {
            $employee->password = Hash::make($request['password']);
        }

        $employee->admin_id = auth('admin')->id();
        $employee->active = $request['active'];
        $employee->update();

        return redirect()->route('getAllEmployees',3)->with('alert-success','تم إضافة المستخدم بنجاح');
    }



    /*** update admins ( managers) ***/
    public function update(AdminUpdateRequest $request)
    {
        $admin = Admin::findOrFail($request->id);
        if ($request->password === $admin->password)
        {
            $admin->update([
                'name' => $request['name'],
                'email' => $request['email'],
                'office_id' => $request['office_id'],
                'admin_id' => auth('admin')->id(),
            ]);
        }
         else{
             $admin->update([
                 'name' => $request['name'],
                 'email' => $request['email'],
                 'office_id' => $request['office_id'],
                 'password' => Hash::make($request['password']),
                 'admin_id' => auth('admin')->id(),
             ]);
         }

        return redirect()->back()->with('alert-success','تم تحديث بيانات المستخدم بنجاح');
    }



    /*** create admins ( managers or employee ) ***/
    public function delete(Request $request)
    {
        Admin::findOrFail($request->id)->delete();
        return redirect()->back()->with('alert-success','تم حذف المستخدم بنجاح');
    }



} //end of class
