<?php

namespace App\Http\Controllers;

use App\Http\Requests\BankRequest;
use App\Models\Bank;
use Illuminate\Http\Request;

class BankController extends Controller
{

    /*** index function ***/
    public function index()
    {
        $banks = Bank::latest()->paginate(page);
        return view('pages.Banks.index', compact('banks'));
    }



    /*** store function ***/
    public function store(BankRequest $request)
    {
        $bank = new Bank();
        $bank->name = $request->name;
        $bank->admin_id = auth('admin')->id();
        $bank->active = 1;
        $bank->save();

        return redirect()->route('banks.index')->with('alert-success','تم تسجيل البيانات بنجاح');
    }



    /*** update function ***/
    public function update(BankRequest $request, Bank $bank)
    {
        $bank->name = $request->name;
        $bank->admin_id = auth('admin')->id();
        $bank->active = $request->active;
        $bank->update();

        return redirect()->route('banks.index')->with('alert-info','تم تعديل البيانات بنجاح');
    }



    /*** destroy function ***/
    public function destroy(Bank $bank)
    {
        $bank->delete();
        return redirect()->route('banks.index')->with('alert-success','تم نقل البيانات إلى سلة المهملات');
    }


} //end of class
