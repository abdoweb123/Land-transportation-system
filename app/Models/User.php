<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable , SoftDeletes;


    protected $fillable = ['name', 'email', 'mobile', 'password', 'admin_id', 'nationalId', 'wallet', 'active'];

    protected $hidden = ['password', 'remember_token',];

    protected $casts = ['email_verified_at' => 'datetime',];



    /*** start relations ***/

    public function admin()
    {
        return $this->belongsTo(Admin::class,'admin_id');
    }


    public function bookedPackages()
    {
        return $this->hasMany(BookedPackage::class,'user_id');
    }


    public function ReservationBookingRequests()
    {
        return $this->hasMany(ReservationBookingRequest::class,'user_id');
    }


    public function shippings()
    {
        return $this->hasMany(Shipping::class,'user_id');
    }

    /*** end relations ***/


} //end of class
