<?php

namespace App\Http\Controllers;


use App\Http\Requests\StateRequest;
use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;

class StateController extends Controller
{

    /*** index function ***/
    public function index()
    {
        $states = State::latest()->paginate(page);
        $countries = Country::where('active',1)->select('id','name')->get();
        return view('pages.States.index', compact('states','countries'));
    }



    /*** store function ***/
    public function store(StateRequest $request)
    {
        $state = new State();
        $state->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
        $state->admin_id = auth('admin')->id();
        $state->country_id = $request->country_id;
        $state->active = 1;
        $state->save();

        return redirect()->route('states.index')->with('alert-success','تم تسجيل البيانات بنجاح');
    }



    /*** update function ***/
    public function update(StateRequest $request, State $state)
    {
        $state->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
        $state->admin_id = auth('admin')->id();
        $state->country_id = $request->country_id;
        $state->active = $request->active;
        $state->update();

        return redirect()->route('states.index')->with('alert-info','تم تعديل البيانات بنجاح');
    }



    /*** destroy function ***/
    public function destroy(State $state)
    {
        $state->delete();
        return redirect()->route('states.index')->with('alert-success','تم نقل البيانات إلى سلة المهملات');
    }


} //end of class
