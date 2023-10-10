<?php

namespace App\Http\Controllers;

use App\Http\Requests\employeeSituationRequest;
use App\Models\EmployeeSituation;
use Illuminate\Http\Request;

class EmployeeSituationController extends Controller
{

    /*** index function ***/
    public function index()
    {
        $employeeSituations = EmployeeSituation::latest()->paginate(page);
        return view('pages.EmployeeSituations.index', compact('employeeSituations'));
    }



    /*** store function ***/
    public function store(employeeSituationRequest $request)
    {
        $employeeSituation = new EmployeeSituation();
        $employeeSituation->name = $request->name;
        $employeeSituation->admin_id = auth('admin')->id();
        $employeeSituation->active = 1;
        $employeeSituation->save();

        return redirect()->route('employeeSituations.index')->with('alert-success','تم تسجيل البيانات بنجاح');
    }



    /*** update function ***/
    public function update(employeeSituationRequest $request, EmployeeSituation $employeeSituation)
    {
        $employeeSituation->name = $request->name;
        $employeeSituation->admin_id = auth('admin')->id();
        $employeeSituation->active = $request->active;
        $employeeSituation->update();

        return redirect()->route('employeeSituations.index')->with('alert-info','تم تعديل البيانات بنجاح');
    }



    /*** destroy function ***/
    public function destroy(EmployeeSituation $employeeSituation)
    {
        $employeeSituation->delete();
        return redirect()->route('employeeSituations.index')->with('alert-success','تم نقل البيانات إلى سلة المهملات');
    }


} //end of class
