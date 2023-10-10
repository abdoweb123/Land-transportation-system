<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Country extends Model
{
    use HasFactory , SoftDeletes , HasTranslations;

    public $translatable = ['name'];

    protected $fillable = ['name', 'admin_id', 'active'];


    /*** start relations ***/


    public function admin()
    {
        return $this->belongsTo(Admin::class,'admin_id');
    }


    public function states()
    {
        return $this->hasMany(State::class,'country_id');
    }

    /*** end relations ***/


} //end of class
