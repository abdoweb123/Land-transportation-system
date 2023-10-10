<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookedPackage extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = ['package_id', 'user_id', 'admin_id', 'startDate', 'used', 'active'];


    /*** start relations ***/

    public function admin()
    {
        return $this->belongsTo(Admin::class,'admin_id');
    }


    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }


    public function package()
    {
        return $this->belongsTo(Package::class,'package_id');
    }


    /*** end relations ***/

} //end of class
