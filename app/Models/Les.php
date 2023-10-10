<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Les extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = ['amount','type','action','ticket_id','admin_id','office_id','active'];

    protected $table = 'les';


    /*** start relations ***/

    public function admin()
    {
        return $this->belongsTo(Admin::class,'admin_id');
    }


    public function office()
    {
        return $this->belongsTo(Office::class,'office_id');
    }


    public function ticket()
    {
        return $this->belongsTo(ReservationBookingRequest::class,'ticket_id');
    }

    /*** end relations ***/

} //end of class
