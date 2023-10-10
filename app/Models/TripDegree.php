<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TripDegree extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['tripData_id', 'admin_id', 'degree_id'];



    public function tripData()
    {
        return $this->belongsTo(TripData::class,'tripData_id');
    }


    public function admin()
    {
        return $this->belongsTo(Admin::class,'admin_id');
    }


    public function degree()
    {
        return $this->belongsTo(Degree::class,'degree_id');
    }


} //end of class
