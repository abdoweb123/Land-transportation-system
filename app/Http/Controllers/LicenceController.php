<?php

namespace App\Http\Controllers;

use App\Http\Requests\LicenceRequest;
use App\Models\Licence;
use Illuminate\Http\Request;

class LicenceController extends Controller
{

    /*** index function ***/
    public function index()
    {
        $licences = Licence::latest()->paginate(page);
        return view('pages.Licences.index', compact('licences'));
    }



    /*** store function ***/
    public function store(LicenceRequest $request)
    {
        $licence = new Licence();
        $licence->name = $request->name;
        $licence->admin_id = auth('admin')->id();
        $licence->active = 1;
        $licence->save();

        return redirect()->route('licences.index')->with('alert-success','تم تسجيل البيانات بنجاح');
    }



    /*** update function ***/
    public function update(LicenceRequest $request, Licence $licence)
    {
        $licence->name = $request->name;
        $licence->admin_id = auth('admin')->id();
        $licence->active = $request->active;
        $licence->update();

        return redirect()->route('licences.index')->with('alert-info','تم تعديل البيانات بنجاح');
    }



    /*** destroy function ***/
    public function destroy(Licence $licence)
    {
        $licence->delete();
        return redirect()->route('licences.index')->with('alert-success','تم نقل البيانات إلى سلة المهملات');
    }


} //end of class
