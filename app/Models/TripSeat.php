<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TripSeat extends Model
{
    use HasFactory , SoftDeletes;


    protected $fillable = ['tripData_id', 'seat_id', 'degree_id', 'admin_id'];



    /*** start relations ***/

    public function tripData()
    {
        return $this->belongsTo(TripData::class,'tripData_id');
    }


    public function seat()
    {
        return $this->belongsTo(Seat::class,'seat_id');
    }


    public function admin()
    {
        return $this->belongsTo(Admin::class,'admin_id');
    }


    public function degree()
    {
        return $this->belongsTo(Degree::class,'degree_id');
    }


    public function bookingSeats()
    {
        return $this->hasMany(BookingSeat::class,'seat_id');
    }


    public function shippings()
    {
        return $this->hasMany(Shipping::class,'tripSeat_id');
    }

    /*** end relations ***/

} // end of class
