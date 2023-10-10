<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Driver extends Model
{
    use HasFactory , SoftDeletes;


    protected $fillable = ['name', 'admin_id', 'image', 'title', 'password', 'role', 'email', 'mobile',
                           'email_verified_at', 'fcm_token', 'bio', 'balance', 'real_balance', 'percentage',
                            'office_id', 'manager','licenceType_id','nationalId','licence_end','taxes_end',
                            'active'
                            ];


    /*** start relations ***/

    public function admin()
    {
        return $this->belongsTo(Admin::class,'admin_id');
    }


    public function office()
    {
        return $this->belongsTo(Office::class,'office_id');
    }


    public function licenceType()
    {
        return $this->belongsTo(Licence::class,'licenceType_id');
    }


    public function buses()
    {
        return $this->hasMany(Bus::class,'driver_id');
    }


    public function runTrips()
    {
        return $this->hasMany(RunTrip::class,'driver_id');
    }


    public function employeeRunTrips()
    {
        return $this->hasMany(EmployeeRunTrip::class,'driver_id');
    }


    public function driverAttachments()
    {
        return $this->hasMany(DriverAttachments::class,'driver_id');
    }


    /*** end relations ***/

} //end of class
