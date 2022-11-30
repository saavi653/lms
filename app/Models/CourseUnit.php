<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CourseUnit extends Pivot
{
    use HasFactory;
    protected $table ='course_units';
    protected $fillable = [

        'course_id',
        'unit_id'
    ];    
   
}
