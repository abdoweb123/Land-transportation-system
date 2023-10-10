<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Queue\Jobs\Job;

class MyEmployee extends Model
{
    use HasFactory , SoftDeletes;


    protected $fillable = ['oracle_id', 'office_id', 'collectionPoint_id', 'employeeJob_id', 'department_id',
                            'admin_id', 'address', 'gender', 'phone', 'email', 'password', 'active'];



    /*** start relations ***/

    public function admin()
    {
        return $this->belongsTo(Admin::class,'admin_id');
    }


    public function office()
    {
        return $this->belongsTo(Office::class,'office_id');
    }


    public function collectionPoint()
    {
        return $this->belongsTo(Station::class,'collectionPoint_id');
    }


    public function EmployeeJob()
    {
        return $this->belongsTo(EmployeeJob::class,'employeeJob_id');
    }


    public function department()
    {
        return $this->belongsTo(Department::class,'department_id');
    }


    public function bookingRequest()
    {
        return $this->hasMany(BookingRequest::class,'employee_id');
    }

    /*** end relations ***/

} //end of class
