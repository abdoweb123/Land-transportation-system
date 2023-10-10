<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = ['title', 'stationFrom_id', 'stationTo_id', 'admin_id', 'max_trips',
                            'max_duration', 'total', 'sub_total', 'active', 'type', 'description'];



    /*** start relations ***/

    public function admin()
    {
        return $this->belongsTo(Admin::class,'admin_id');
    }


    public function stationFrom()
    {
        return $this->belongsTo(Station::class,'stationFrom_id');
    }


    public function stationTo()
    {
        return $this->belongsTo(Station::class,'stationTo_id');
    }


    public function bookedPackages()
    {
        return $this->hasMany(BookedPackage::class,'package_id');
    }

    /*** end relations ***/

} // end of class
