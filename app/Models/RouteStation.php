<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RouteStation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['route_id', 'station_id', 'station_name', 'admin_id', 'active'];



    /*** start relations ***/

    public function admin()
    {
        return $this->belongsTo(Admin::class,'admin_id');
    }


    public function station()
    {
        return $this->belongsTo(Station::class,'station_id');
    }


    public function route()
    {
        return $this->belongsTo(Route::class,'route_id');
    }
    /*** end relations ***/

} //end of class
