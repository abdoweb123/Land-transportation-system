<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConnectRunTrips extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['runTrip_go_id', 'runTrip_back_id', 'admin_id'];



    /*** start relations ***/

    public function admin()
    {
        return $this->belongsTo(Admin::class,'admin_id');
    }


    public function runTrip_go()
    {
        return $this->belongsTo(RunTrip::class,'runTrip_go_id');
    }


    public function runTrip_back()
    {
        return $this->belongsTo(RunTrip::class,'runTrip_back_id');
    }

   /*** end relations ***/



} //end of class
