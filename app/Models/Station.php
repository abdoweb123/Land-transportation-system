<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Station extends Model
{
    use HasFactory , SoftDeletes;
    use HasTranslations;

    public $translatable = ['name'];

    protected $fillable = ['name', 'city_id', 'admin_id', 'active'];



    /*** start relations ***/

    public function city()
    {
        return $this->belongsTo(City::class,'city_id');
    }


    public function admin()
    {
        return $this->belongsTo(Admin::class,'admin_id');
    }


    public function tripStations()
    {
        return $this->hasMany(TripStation::class,'station_id');
    }


    public function FromPackages()
    {
        return $this->hasMany(Package::class,'stationFrom_id');
    }


    public function ToPackages()
    {
        return $this->hasMany(Package::class,'stationTo_id');
    }


    public function offices()
    {
        return $this->hasMany(Office::class,'stationTo_id');
    }


    public function myEmployees()
    {
        return $this->hasMany(MyEmployee::class,'collectionPoint_id');
    }


    public function routeStations()
    {
        return $this->hasMany(RouteStation::class,'station_id');
    }


    public function bookingRequestFrom()
    {
        return $this->hasMany(BookingRequest::class,'collection_point_from_id');
    }


    public function bookingRequestTo()
    {
        return $this->hasMany(BookingRequest::class,'collection_point_to_id');
    }


    public function ReservationBookingRequestsFrom()
    {
        return $this->hasMany(ReservationBookingRequest::class,'stationFrom_id');
    }


    public function ReservationBookingRequestsTo()
    {
        return $this->hasMany(ReservationBookingRequest::class,'stationTo_id');
    }


    public function lineFrom()
    {
        return $this->hasMany(Line::class,'from_id');
    }


    public function lineTo()
    {
        return $this->hasMany(Line::class,'to_id');
    }


    public function shippingsFrom()
    {
        return $this->hasMany(Shipping::class,'from_station_id');
    }


    public function shippingsTo()
    {
        return $this->hasMany(Shipping::class,'to_station_id');
    }

    /*** end relations ***/

} //end of class
