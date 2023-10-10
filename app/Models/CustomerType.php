<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class CustomerType extends Model
{
    use HasFactory , SoftDeletes , HasTranslations;


    public $translatable = ['name'];

    protected $fillable = ['name', 'active', 'admin_id'];


    /*** start relations ***/

    public function admin()
    {
        return $this->belongsTo(Admin::class,'admin_id');
    }


    public function coupons()
    {
        return $this->belongsTo(Coupon::class,'customerType_id');
    }


    /*** end relations ***/

} //end of class
