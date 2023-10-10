<?php

namespace App\Http\Controllers;

use App\Http\Requests\BusModelRequest;
use App\Models\BusModel;
use Illuminate\Http\Request;

class BusModelController extends Controller
{

    /*** index function ***/
    public function index()
    {
        $busModels = BusModel::latest()->paginate(page);
        return view('pages.BusModels.index', compact('busModels'));
    }



    /*** store function ***/
    public function store(BusModelRequest $request)
    {
        $busModel = new BusModel();
        $busModel->name = $request->name;
        $busModel->admin_id = auth('admin')->id();
        $busModel->active = 1;
        $busModel->save();

        return redirect()->route('busModels.index')->with('alert-success','تم تسجيل البيانات بنجاح');
    }



    /*** update function ***/
    public function update(BusModelRequest $request, BusModel $busModel)
    {
        $busModel->name = $request->name;
        $busModel->admin_id = auth('admin')->id();
        $busModel->active = $request->active;
        $busModel->update();

        return redirect()->route('busModels.index')->with('alert-info','تم تعديل البيانات بنجاح');
    }



    /*** destroy function ***/
    public function destroy(BusModel $busModel)
    {
        $busModel->delete();
        return redirect()->route('busModels.index')->with('alert-success','تم نقل البيانات إلى سلة المهملات');
    }


} //end of class
