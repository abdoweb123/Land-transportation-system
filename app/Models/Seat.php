<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Seat extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = ['name','admin_id','status','busType_id','type'];


    public function showType($val)
    {
        switch ($val){
            case 1: echo 'متاح'; break;
            case 2: echo 'غير متاح'; break;
            case 3: echo 'سائق'; break;
        }
    }


    /*** start relations ***/

    public function busType()
    {
        return $this->belongsTo(BusType::class,'busType_id');
    }


    public function admin()
    {
        return $this->belongsTo(Admin::class,'admin_id');
    }


    public function tripSeats()
    {
        return $this->hasMany(TripSeat::class,'seat_id');
    }

    /*** end relations ***/

} //end of class

