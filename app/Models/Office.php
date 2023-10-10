<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Office extends Model
{
    use HasFactory , HasTranslations , SoftDeletes;

    public $translatable = ['name'];

    protected $fillable = ['name', 'admin_id','station_id', 'active'];


    public function city()
    {
        return $this->belongsTo(City::class,'city_id');
    }


    public function admin()
    {
        return $this->belongsTo(Admin::class,'admin_id');
    }


    public function station()
    {
        return $this->belongsTo(Station::class,'station_id');
    }


    public function drivers()
    {
        return $this->hasMany(Driver::class,'office_id');
    }


    public function myEmployees()
    {
        return $this->hasMany(MyEmployee::class,'office_id');
    }


    public function ReservationBookingRequests()
    {
        return $this->hasMany(ReservationBookingRequest::class,'office_id');
    }


    public function less()
    {
        return $this->hasMany(Les::class,'office_id');
    }


    public function bookingSeats()
    {
        return $this->hasMany(BookingSeat::class,'office_id');
    }

} //end of class
