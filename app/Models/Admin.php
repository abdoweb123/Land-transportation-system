<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin  extends Authenticatable
{
    use HasFactory , SoftDeletes;

    protected $fillable = ['name', 'email', 'password', 'type', 'office_id', 'admin_id',
                           'code', 'office_id', 'department_id', 'employeeJob_id', 'active',
                           'employeeSituation_id', 'birthdate', 'appointDate', 'degree'];


    public function getTypeAttribute($val)
    {
        switch ($val)
        {
            case 1: echo 'المشرف العام'; break;
            case 2: echo 'مدير الفرع'; break;
            case 3: echo 'موظف البيانات'; break;
        }
    }



    /*** start relations ***/

    public function parent()
    {
        return $this->belongsTo(Admin::class,'admin_id');
    }


    public function office()
    {
        return $this->belongsTo(Office::class,'office_id');
    }


    public function department()
    {
        return $this->belongsTo(Department::class,'department_id');
    }


    public function employeeJob()
    {
        return $this->belongsTo(EmployeeJob::class,'employeeJob_id');
    }


    public function employeeSituation()
    {
        return $this->belongsTo(EmployeeSituation::class,'employeeSituation_id');
    }


    public function countries()
    {
        return $this->hasMany(Country::class,'admin_id');
    }


    public function states()
    {
        return $this->hasMany(State::class,'admin_id');
    }


    public function busModels()
    {
        return $this->hasMany(BusModel::class,'admin_id');
    }


    public function busOwners()
    {
        return $this->hasMany(BusOwner::class,'admin_id');
    }


    public function insuranceCompanies()
    {
        return $this->hasMany(InsuranceCompany::class,'admin_id');
    }


    public function banks()
    {
        return $this->hasMany(Bank::class,'admin_id');
    }


    public function children()
    {
        return $this->hasMany(Admin::class,'admin_id');
    }


    public function cities()
    {
        return $this->hasMany(City::class,'admin_id');
    }


    public function buses()
    {
        return $this->hasMany(Bus::class,'admin_id');
    }


    public function buseAttachments()
    {
        return $this->hasMany(BusAttachments::class,'admin_id');
    }


    public function driverAttachments()
    {
        return $this->hasMany(DriverAttachments::class,'admin_id');
    }


    public function employeeSituations()
    {
        return $this->hasMany(EmployeeSituation::class,'admin_id');
    }


    public function licences()
    {
        return $this->hasMany(Licence::class,'admin_id');
    }


    public function seats()
    {
        return $this->hasMany(Seat::class,'admin_id');
    }


    public function drivers()
    {
        return $this->hasMany(Driver::class,'admin_id');
    }


    public function stations()
    {
        return $this->hasMany(Station::class,'admin_id');
    }


    public function busTypes()
    {
        return $this->hasMany(BusType::class,'admin_id');
    }


    public function users()
    {
        return $this->hasMany(User::class,'admin_id');
    }


    public function offices()
    {
        return $this->hasMany(Office::class,'admin_id');
    }


    public function degrees()
    {
        return $this->hasMany(Degree::class,'admin_id');
    }


    public function tripData()
    {
        return $this->hasMany(TripData::class,'admin_id');
    }


    public function tripStations()
    {
        return $this->hasMany(TripStation::class,'admin_id');
    }


    public function lines()
    {
        return $this->hasMany(Line::class,'admin_id');
    }


    public function adminRunTrips()
    {
        return $this->hasMany(RunTrip::class,'admin_id');
    }


    public function hostRunTrips()
    {
        return $this->hasMany(RunTrip::class,'host_id');
    }


    public function tripDegrees()
    {
        return $this->hasMany(TripDegree::class,'admin_id');
    }


    public function tripSeats()
    {
        return $this->hasMany(TripSeat::class,'admin_id');
    }


    public function coupons()
    {
        return $this->hasMany(Coupon::class,'admin_id');
    }


    public function couponTrips()
    {
        return $this->hasMany(CouponTrip::class,'admin_id');
    }


    public function packages()
    {
        return $this->hasMany(Package::class,'admin_id');
    }


    public function bookedPackages()
    {
        return $this->hasMany(BookedPackage::class,'admin_id');
    }


    public function customerTypes()
    {
        return $this->hasMany(CustomerType::class,'admin_id');
    }


    public function millages()
    {
        return $this->hasMany(Millage::class,'admin_id');
    }


    public function vendors()
    {
        return $this->hasMany(Vendor::class,'admin_id');
    }


    public function categories()
    {
        return $this->hasMany(Category::class,'admin_id');
    }


    public function efficiencyFuels()
    {
        return $this->hasMany(EfficiencyFuel::class,'admin_id');
    }


    public function manuallyFuels()
    {
        return $this->hasMany(ManuallyFuel::class,'admin_id');
    }


    public function employeeJobs()
    {
        return $this->hasMany(EmployeeJob::class,'admin_id');
    }


    public function departments()
    {
        return $this->hasMany(Department::class,'admin_id');
    }


    public function myEmployees()
    {
        return $this->hasMany(MyEmployee::class,'admin_id');
    }


    public function routes()
    {
        return $this->hasMany(Route::class,'admin_id');
    }


    public function routeStations()
    {
        return $this->hasMany(RouteStation::class,'admin_id');
    }


    public function bookingRequest()
    {
        return $this->hasMany(BookingRequest::class,'admin_id');
    }


    public function employeeRunTrips()
    {
        return $this->hasMany(EmployeeRunTrip::class,'admin_id');
    }


    public function ReservationBookingRequests()
    {
        return $this->hasMany(ReservationBookingRequest::class,'admin_id');
    }


    public function bookingSeats()
    {
        return $this->hasMany(BookingSeat::class,'admin_id');
    }


    public function shippings()
    {
        return $this->hasMany(Shipping::class,'admin_id');
    }


    public function settings()
    {
        return $this->hasMany(Settings::class,'admin_id');
    }


    public function less()
    {
        return $this->hasMany(Les::class,'admin_id');
    }

    /*** end relations ***/

} //end of class
