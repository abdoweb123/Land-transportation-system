<?php

namespace App\Http\Controllers;

use App\Http\Requests\InsuranceCompanyRequest;
use App\Models\InsuranceCompany;
use Illuminate\Http\Request;

class InsuranceCompanyController extends Controller
{

    /*** index function ***/
    public function index()
    {
        $insuranceCompanies = InsuranceCompany::latest()->paginate(page);
        return view('pages.InsuranceCompanies.index', compact('insuranceCompanies'));
    }



    /*** store function ***/
    public function store(InsuranceCompanyRequest $request)
    {
        $insuranceCompany = new InsuranceCompany();
        $insuranceCompany->name = $request->name;
        $insuranceCompany->admin_id = auth('admin')->id();
        $insuranceCompany->active = 1;
        $insuranceCompany->save();

        return redirect()->route('insuranceCompanies.index')->with('alert-success','تم تسجيل البيانات بنجاح');
    }



    /*** update function ***/
    public function update(InsuranceCompanyRequest $request, InsuranceCompany $insuranceCompany)
    {
        $insuranceCompany->name = $request->name;
        $insuranceCompany->admin_id = auth('admin')->id();
        $insuranceCompany->active = $request->active;
        $insuranceCompany->update();

        return redirect()->route('insuranceCompanies.index')->with('alert-info','تم تعديل البيانات بنجاح');
    }



    /*** destroy function ***/
    public function destroy(InsuranceCompany $insuranceCompany)
    {
        $insuranceCompany->delete();
        return redirect()->route('insuranceCompanies.index')->with('alert-success','تم نقل البيانات إلى سلة المهملات');
    }


} //end of class
