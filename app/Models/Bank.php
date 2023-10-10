<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Bank extends Model
{

    use HasFactory , SoftDeletes;

    protected $fillable = ['name', 'admin_id', 'active'];



    /*** start relations ***/

    public function admin()
    {
        return $this->belongsTo(Admin::class,'admin_id');
    }


    public function buses()
    {
        return $this->hasMany(Bus::class,'bank_id');
    }

    /*** end relations ***/


} //end of class
