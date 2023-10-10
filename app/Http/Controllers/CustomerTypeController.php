<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Models\CustomerType;
use Illuminate\Http\Request;

class CustomerTypeController extends Controller
{

    /*** index function  ***/
    public function index()
    {
        $customerTypes = CustomerType::latest()->paginate(page);
        return view('pages.CustomerTypes.index', compact('customerTypes'));
    }



    /*** store function  ***/
    public function store(CustomerRequest $request)
    {
        $customerType = new CustomerType();
        $customerType->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
        $customerType->admin_id = auth('admin')->id();
        $customerType->active = 1;
        $customerType->save();

        return redirect()->route('customerTypes.index')->with('alert-success','تم حفظ البيانات بنجاح');
    }



    /*** update function  ***/
    public function update(CustomerRequest $request, CustomerType $customerType)
    {
        $customerType->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
        $customerType->admin_id = auth('admin')->id();
        $customerType->active = $request->active;
        $customerType->update();

        return redirect()->route('customerTypes.index')->with('alert-info','تم تحديث البيانات بنجاح');
    }



    /*** destroy function  ***/
    public function destroy(Request $request, CustomerType $customerType)
    {
        $customerType->delete();
        return redirect()->route('customerTypes.index')->with('alert-success','تم حذف البيانات بنجاح');
    }


} //end of class
