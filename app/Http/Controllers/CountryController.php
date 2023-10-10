<?php

namespace App\Http\Controllers;

use App\Http\Requests\CountryRequest;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{

    /*** index function ***/
    public function index()
    {
        $countries = Country::latest()->paginate(page);
        return view('pages.Countries.index', compact('countries'));
    }



    /*** store function ***/
    public function store(CountryRequest $request)
    {
        $country = new Country();
        $country->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
        $country->admin_id = auth('admin')->id();
        $country->active = 1;
        $country->save();

        return redirect()->route('countries.index')->with('alert-success','تم تسجيل البيانات بنجاح');
    }



    /*** update function ***/
    public function update(CountryRequest $request, Country $country)
    {
        $country->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
        $country->admin_id = auth('admin')->id();
        $country->active = $request->active;
        $country->update();

        return redirect()->route('countries.index')->with('alert-info','تم تعديل البيانات بنجاح');
    }



    /*** destroy function ***/
    public function destroy(Country $country)
    {
        $country->delete();
        return redirect()->route('countries.index')->with('alert-success','تم نقل البيانات إلى سلة المهملات');
    }


} //end of class
