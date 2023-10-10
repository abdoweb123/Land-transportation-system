<?php

namespace App\Http\Controllers;

use App\Models\Les;
use Illuminate\Http\Request;

class LesController extends Controller
{

  /*** get les money page ***/
  public function getLesMoney()
  {
      $less = Les::latest()->paginate(page);
      $lessNotifications = Les::latest()->paginate(10);
      $less_type1 = Les::where('type',1)->sum('amount');  // الصادر
      $less_type2 = Les::where('type',2)->sum('amount'); // الوارد
      return view('pages.Reports.lesMoney',compact('less','less_type1','less_type2'));
  }

} //end of class
