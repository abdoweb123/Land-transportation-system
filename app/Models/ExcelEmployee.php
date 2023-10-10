<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExcelEmployee extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = ['name', 'lob', 'oracle', 'site', 'route', 'cp', 'gender', 'date',
                            'shift', 'start', 'end'];



} //end of class
