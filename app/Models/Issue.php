<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Issue extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = ['category_id', 'title', 'description', 'priority', 'type', 'admin_id', 'active'];



    /*** start relations ***/

    public function admin()
    {
        return $this->belongsTo(Admin::class,'admin_id');
    }


    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }

    /*** end relations ***/

} //end of class
