<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeRunTrip extends Model
{
    use HasFactory , SoftDeletes;


    protected $fillable = ['date', 'time', 'route_id', 'driver_id', 'admin_id', 'active'];



    /*** start relations ***/

    public function admin()
    {
        return $this->belongsTo(Admin::class,'admin_id');
    }


    public function route()
    {
        return $this->belongsTo(Route::class,'route_id');
    }


    public function driver()
    {
        return $this->belongsTo(Driver::class,'driver_id');
    }


    public function bus()
    {
        return $this->belongsToMany(Bus::class,'employee_run_trip_buses','employeeRunTrip_id', 'bus_id');
    }

    /*** end relations ***/

} //end of class
