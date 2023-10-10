<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Line extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = ['tripData_id', 'stationFrom_id', 'stationTo_id', 'degree_id', 'admin_id',
                            'active', 'priceGo', 'priceBack', 'priceForeignerGo', 'priceForeignerBack',
                            'setting_id', 'cancelFee', 'editFee', 'from_id', 'to_id'];



    public function admin()
    {
        return $this->belongsTo(Admin::class,'admin_id');
    }


    public function stationFrom()
    {
        return $this->belongsTo(TripStation::class,'stationFrom_id');
    }


    public function stationTo()
    {
        return $this->belongsTo(TripStation::class,'stationTo_id');
    }


    public function from()
    {
        return $this->belongsTo(Station::class,'from_id');
    }


    public function to()
    {
        return $this->belongsTo(Station::class,'to_id');
    }


    public function tripData()
    {
        return $this->belongsTo(TripData::class,'tripData_id');
    }


    public function degree()
    {
        return $this->belongsTo(Degree::class,'degree_id');
    }


} //end of class
