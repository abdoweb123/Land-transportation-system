<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bus extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = ['code', 'name', 'chassis', 'motor_number', 'busModel_id', 'busOwner_id',
                           'insuranceCompany_id', 'bank_id', 'busType_id', 'driver_id',
                           'licenceStart', 'licenceEnd', 'taxesStart', 'taxesEnd',
                           'driverLicenceStart',  'driverLicenceEnd', 'admin_id', 'active'];



    /*** start relations ***/

    public function admin()
    {
        return $this->belongsTo(Admin::class,'admin_id');
    }


    public function busModel()
    {
        return $this->belongsTo(BusModel::class,'busModel_id');
    }


    public function busOwner()
    {
        return $this->belongsTo(BusOwner::class,'busOwner_id');
    }


    public function insuranceCompany()
    {
        return $this->belongsTo(InsuranceCompany::class,'insuranceCompany_id');
    }


    public function bank()
    {
        return $this->belongsTo(Bank::class,'bank_id');
    }


    public function busType()
    {
        return $this->belongsTo(BusType::class,'busType_id');
    }


    public function driver()
    {
        return $this->belongsTo(Driver::class,'driver_id');
    }


    public function runTrips()
    {
        return $this->hasMany(RunTrip::class,'bus_id');
    }


    public function efficiencyFuels()
    {
        return $this->hasMany(EfficiencyFuel::class,'bus_id');
    }


    public function manuallyFuels()
    {
        return $this->hasMany(ManuallyFuel::class,'bus_id');
    }


    public function bookingRequest()
    {
        return $this->hasMany(BookingRequest::class,'bus_id');
    }


    public function employeeRunTrip()
    {
        return $this->belongsToMany(Bus::class,'employee_run_trip_buses', 'bus_id','employeeRunTrip_id');
    }


    public function busAttachments()
    {
        return $this->hasMany(BusAttachments::class,'bus_id');
    }

   /*** end relations ***/

} //end of class
