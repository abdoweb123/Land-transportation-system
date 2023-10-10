<?php

namespace App\Http\Controllers;

use App\Imports\EmployeeExcel;
use App\Imports\EmployeeImport;
use App\Models\ExcelEmployee;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        return view('dashboard');
    }



}
