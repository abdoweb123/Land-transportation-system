<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeJob extends Model
{
    use HasFactory , SoftDeletes;


    protected $fillable = ['name', 'admin_id', 'active'];



    /*** start relations ***/

    public function admin()
    {
        return $this->belongsTo(Admin::class,'admin_id');
    }


    public function myEmployees()
    {
        return $this->hasMany(MyEmployee::class,'EmployeeJob_id');
    }


    public function employees()
    {
        return $this->hasMany(Admin::class,'employeeJob_id');
    }

    /*** end relations ***/

} //end of class
