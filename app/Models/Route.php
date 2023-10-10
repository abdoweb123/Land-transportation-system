<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Route extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = ['name', 'admin_id', 'active'];



    /*** start relations ***/

    public function admin()
    {
        return $this->belongsTo(Admin::class,'admin_id');
    }


    public function routeStations()
    {
        return $this->hasMany(RouteStation::class,'route_id');
    }


    public function bookingRequest()
    {
        return $this->hasMany(BookingRequest::class,'route_id');
    }


    public function employeeRunTrips()
    {
        return $this->hasMany(EmployeeRunTrip::class,'route_id');
    }

    /*** end relations ***/

} //end of class
