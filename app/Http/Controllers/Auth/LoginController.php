<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Traits\AuthTrait;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{


//    use AuthenticatesUsers;



    /*** showLoginForm for admins ***/
    public function showLoginForm()
    {
        $company_arabic_name = $this->company_arabic_name;
        $company_english_name = $this->company_english_name;

        return view('authAdmin.login',compact('company_arabic_name','company_english_name'));
    }



    /*** login for admins ***/
    public function login(LoginRequest $request){

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {

            return redirect()->intended('branches/admin/dashboard');
        }
        else{
            return redirect()->back()->withInput(['email','password'])->with('alert-danger', 'يوجد خطا في كلمة المرور او اسم المستخدم أو النوع');
        }

    }



    /*** logout for admins ***/
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }



} //end of class
