<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusType extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = ['name', 'admin_id', 'length', 'width', 'slug', 'active'];


    public function admin()
    {
        return $this->belongsTo(Admin::class,'admin_id');
    }


    public function buses()
    {
        return $this->hasMany(Bus::class,'busType_id');
    }


    public function seats()
    {
        return $this->hasMany(Seat::class,'busType_id');
    }


    public function tripData()
    {
        return $this->hasMany(TripData::class,'busType_id');
    }


} //end of class
