<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DriverAttachments extends Model
{

    use HasFactory , SoftDeletes;

    protected $fillable = ['name','fileName', 'admin_id', 'driver_id', 'active'];



    /*** start relations ***/

    public function admin()
    {
        return $this->belongsTo(Admin::class,'admin_id');
    }


    public function driver()
    {
        return $this->belongsTo(Driver::class,'driver_id');
    }


    /*** end relations ***/

} //end of class
