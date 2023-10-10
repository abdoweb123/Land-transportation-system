<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shipping extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = ['description', 'mass', 'volume', 'price', 'receiver_nationalId', 'receiving', 'delivering',
        'user_on_the_trip', 'breakable', 'fast', 'user_id', 'user_phone', 'from_station_id', 'to_station_id', 'tripSeat_id',
        'run_trip_id', 'receiver_phone', 'receiver_name', 'other1', 'other2', 'admin_id', 'active'];



    /*** start relations ***/

    public function admin()
    {
        return $this->belongsTo(Admin::class,'admin_id');
    }


    public function runTrip()
    {
        return $this->belongsTo(RunTrip::class,'run_trip_id');
    }



    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }


    public function stationFrom()
    {
        return $this->belongsTo(Station::class,'from_station_id');
    }


    public function stationTo()
    {
        return $this->belongsTo(Station::class,'to_station_id');
    }


    public function tripSeat()
    {
        return $this->belongsTo(TripSeat::class,'tripSeat_id');
    }

    /*** end relations ***/



} //end of class
