<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class City extends Model
{
    use HasFactory , SoftDeletes;
    use HasTranslations;

    public $translatable = ['name'];

    protected $fillable = ['name', 'admin_id', 'state_id', 'active'];



    /*** start relations ***/

    public function stations()
    {
        return $this->hasMany(Station::class,'city_id');
    }

    public function offices()
    {
        return $this->hasMany(Office::class,'city_id');
    }


    public function admin()
    {
        return $this->belongsTo(Admin::class,'admin_id');
    }


    public function state()
    {
        return $this->belongsTo(State::class,'state_id');
    }


    public function bookingSeats()
    {
        return $this->hasMany(BookingSeat::class,'city_id');
    }

    /*** end relations ***/

} //end of class
