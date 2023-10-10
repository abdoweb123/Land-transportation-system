<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TripStation extends Model
{
    use HasFactory , SoftDeletes;


    protected $fillable = ['station_id', 'tripData_id', 'admin_id', 'type', 'timeInMinutes', 'rank',
                            'printTimes', 'distance'];


     public function admin()
     {
        return $this->belongsTo(Admin::class,'admin_id');
     }


    public function tripData()
    {
        return $this->belongsTo(TripData::class,'tripData_id');
    }


    public function station()
    {
        return $this->belongsTo(Station::class,'station_id');
    }


    public function fromLines()
    {
        return $this->hasMany(Line::class,'stationFrom_id');
    }


    public function toLines()
    {
        return $this->hasMany(Line::class,'stationTo_id');
    }


} //end class

