<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingRequest extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = ['collection_point_from_id', 'collection_point_to_id', 'route_id', 'date',
                            'time', 'seat_number', 'bus_id', 'employee_id', 'shift', 'address',
                            'admin_id', 'active'];



    /*** start relations ***/

    public function admin()
    {
        return $this->belongsTo(Admin::class,'admin_id');
    }


    public function collection_point_from()
    {
        return $this->belongsTo(Station::class,'collection_point_from_id');
    }


    public function collection_point_to()
    {
        return $this->belongsTo(Station::class,'collection_point_to_id');
    }


    public function route()
    {
        return $this->belongsTo(Route::class,'route_id');
    }


    public function myEmployee()
    {
        return $this->belongsTo(MyEmployee::class,'employee_id');
    }



    public function bus()
    {
        return $this->belongsTo(Bus::class,'bus_id');
    }


    /*** end relations ***/



} //end of class
