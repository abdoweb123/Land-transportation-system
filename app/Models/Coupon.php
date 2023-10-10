<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use HasFactory , SoftDeletes;


    protected $fillable = ['code', 'amount', 'percent', 'startDate', 'endDate', 'max_amount',
                            'max_users', 'used_by', 'used_count', 'active', 'admin_id', 'notes',
                            'max_per_user', 'customerType_id'];



    /*** start relations ***/

    public function admin()
    {
        return $this->belongsTo(Admin::class,'admin_id');
    }


    public function customerType()
    {
        return $this->belongsTo(CustomerType::class,'customerType_id');
    }


    public function couponTrips()
    {
        return $this->hasMany(CouponTrip::class,'coupon_id');
    }


    public function millages()
    {
        return $this->hasMany(Millage::class,'coupon_id');
    }


    public function ReservationBookingRequests()
    {
        return $this->hasMany(ReservationBookingRequest::class,'coupon_id');
    }


    public function trips()
    {
        return $this->belongsToMany(TripData::class,'coupon_trips','coupon_id','tripData_id');
    }


    /*** end relations ***/


} //end of class
