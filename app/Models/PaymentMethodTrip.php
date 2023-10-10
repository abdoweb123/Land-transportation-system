<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentMethodTrip extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['tripData_id', 'admin_id', 'paymentMethod_id'];



    public function tripData()
    {
        return $this->belongsTo(TripData::class,'tripData_id');
    }


    public function admin()
    {
        return $this->belongsTo(Admin::class,'admin_id');
    }



} //end of class
