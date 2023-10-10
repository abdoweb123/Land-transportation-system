<?php

namespace App\Http\Controllers;

use App\Http\Requests\DegreeRequest;
use App\Models\Degree;
use Illuminate\Http\Request;

class DegreeController extends Controller
{

    /*** index function  ***/
    public function index()
    {
        $degrees = Degree::latest()->paginate(page);
        return view('pages.Degrees.index', compact('degrees'));
    }



    /*** store function  ***/
    public function store(DegreeRequest $request)
    {
        try {
            $degree = new Degree();
            $degree->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
            $degree->admin_id = auth('admin')->id();
            $degree->active = 1;
            $degree->save();
            return redirect()->route('degrees.index')->with('alert-success','تم تسجيل البيانات بنجاح');
        }
        catch (\Exception $exception)
        {
            return redirect()->back()->withErrors(['error' => $exception->getMessage()]);
        }
    }



    /*** update function  ***/
    public function update(DegreeRequest $request)
    {
        try {
            $degree = Degree::findOrFail($request->id);
            $degree->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
            $degree->admin_id = auth('admin')->id();
            $degree->active = $request->active;
            $degree->update();
            return redirect()->route('degrees.index')->with('alert-info','تم تحديث البيانات بنجاح');
        }
        catch (\Exception $exception)
        {
            return redirect()->back()->withErrors(['error' => $exception->getMessage()]);
        }
    }



    /*** destroy function  ***/
    public function destroy(Request $request)
    {
        Degree::findOrFail($request->id)->delete();
        return redirect()->route('degrees.index')->with('alert-success','تم حذف البيانات بنجاح');
    }

} //end of class
