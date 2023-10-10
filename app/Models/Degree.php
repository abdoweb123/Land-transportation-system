<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Degree extends Model
{
    use HasFactory , SoftDeletes;
    use HasTranslations;

    public $translatable = ['name'];

    protected $fillable = ['name', 'admin_id', 'active'];


    public function admin()
    {
        return $this->belongsTo(Admin::class,'admin_id');
    }


    public function tripDegrees()
    {
        return $this->hasMany(TripDegree::class,'degree_id');
    }


    public function lines()
    {
        return $this->hasMany(Line::class,'degree_id');
    }


    public function tripSeats()
    {
        return $this->hasMany(TripSeat::class,'degree_id');
    }


    public function bookingSeats()
    {
        return $this->hasMany(BookingSeat::class,'degree_id');
    }


} //end of class
