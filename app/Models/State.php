<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class State extends Model
{

    use HasFactory , SoftDeletes , HasTranslations;

    public $translatable = ['name'];

    protected $fillable = ['name', 'admin_id', 'country_id', 'active'];


    /*** start relations ***/

    public function admin()
    {
        return $this->belongsTo(Admin::class,'admin_id');
    }


    public function country()
    {
        return $this->belongsTo(Country::class,'country_id');
    }


    public function cities()
    {
        return $this->hasMany(City::class,'state_id');
    }

    /*** end relations ***/


} //end of class
