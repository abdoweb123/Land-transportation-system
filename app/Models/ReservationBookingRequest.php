<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReservationBookingRequest extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = ['runTrip_id', 'trip_id', 'user_id', 'stationFrom_id', 'go_ticket_id',
                           'secret_code', 'stationTo_id', 'coupon_id', 'address', 'total', 'sub_total',
                           'admin_id', 'office_id', 'active'];



    /*** start relations ***/

    public function admin()
    {
        return $this->belongsTo(Admin::class,'admin_id');
    }


    public function office()
    {
        return $this->belongsTo(Office::class,'office_id');
    }


    public function runTrip()
    {
        return $this->belongsTo(RunTrip::class,'runTrip_id');
    }


    public function tripData()
    {
        return $this->belongsTo(TripData::class,'trip_id');
    }


    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }


    public function stationFrom()
    {
        return $this->belongsTo(Station::class,'stationFrom_id');
    }


    public function stationTo()
    {
        return $this->belongsTo(Station::class,'stationTo_id');
    }


    public function coupon()
    {
        return $this->belongsTo(Coupon::class,'coupon_id');
    }


    public function bookingSeats()
    {
        return $this->hasMany(BookingSeat::class,'booking_id');
    }


    public function less()
    {
        return $this->hasMany(Les::class,'ticket_id');
    }

    /*** end relations ***/



} //end of class
