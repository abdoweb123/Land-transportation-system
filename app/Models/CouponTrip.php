<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CouponTrip extends Model
{
    use HasFactory , SoftDeletes;


    protected $fillable = ['tripData_id', 'coupon_id', 'admin_id', 'active'];



    /*** start relations ***/

    public function admin()
    {
        return $this->belongsTo(Admin::class,'admin_id');
    }


    public function coupon()
    {
        return $this->belongsTo(Coupon::class,'coupon_id');
    }


    public function tripData()
    {
        return $this->belongsTo(TripData::class,'tripData_id');
    }

    /*** end relations ***/

} // end of class
