<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;

class RegisterUserController extends Controller
{


    /*** showRegisterForm for users ***/
    public function showRegisterForm()
    {
        return view('auth.UserRegister');
    }



    /*** register for users ***/
    public function register(UserStoreRequest $request)
    {
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'admin_id' => auth('admin')->id(),
            'password' => Hash::make($request['password']),
        ]);

        return redirect()->back()->with('alert-success','تم إضافة المستخدم بنجاح');
    }



} //end of class
