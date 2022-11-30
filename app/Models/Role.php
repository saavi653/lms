<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    CONST ADMIN=1;
    CONST SUB_ADMIN=2;
    CONST TRAINER=3;
    CONST EMPLOYEE=4;

    public function scopeRole($query)
    {
        return $query->where('id','!=',self::ADMIN)->get();
    }
}
