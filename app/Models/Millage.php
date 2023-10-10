<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Millage extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = ['type', 'minimum', 'coupon_id', 'admin_id', 'notes'];



    /*** start relations ***/

    public function admin()
    {
        return $this->belongsTo(Admin::class,'admin_id');
    }


    public function coupon()
    {
        return $this->belongsTo(Coupon::class,'coupon_id');
    }

    /*** end relations ***/

} // end of class
