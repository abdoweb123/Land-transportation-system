<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusAttachments extends Model
{
    use HasFactory , SoftDeletes;


    protected $fillable = ['name','fileName', 'admin_id', 'bus_id', 'active'];



    /*** start relations ***/

    public function admin()
    {
        return $this->belongsTo(Admin::class,'admin_id');
    }


    public function bus()
    {
        return $this->belongsTo(Bus::class,'bus_id');
    }


    /*** end relations ***/

} //end of class
