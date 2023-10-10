<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingSeat extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = ['booking_id', 'runTrip_id', 'seat_id', 'tripStationFrom_id', 'tripStationTo_id',
                           'degree_id', 'office_id', 'city_id', 'admin_id', 'total', 'active'];



    /*** start relations ***/

    public function admin()
    {
        return $this->belongsTo(Admin::class,'admin_id');
    }


    public function reservationBooking()
    {
        return $this->belongsTo(ReservationBookingRequest::class,'booking_id');
    }


    public function runTrip()
    {
        return $this->belongsTo(RunTrip::class,'runTrip_id');
    }


    public function tripSeat()
    {
        return $this->belongsTo(TripSeat::class,'seat_id');
    }


    public function degree()
    {
        return $this->belongsTo(Degree::class,'degree_id');
    }


    public function office()
    {
        return $this->belongsTo(Office::class,'office_id');
    }


    public function city()
    {
        return $this->belongsTo(City::class,'city_id');
    }


    public function tripStationFrom()
    {
        return $this->belongsTo(TripStation::class,'tripStationFrom_id');
    }


    public function tripStationTo()
    {
        return $this->belongsTo(TripStation::class,'tripStationTo_id');
    }

    /*** end relations ***/

} //end of class
