<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'status',
        'created_by',
        'slug'
    ];
    public function user(){
      
        return $this->belongsTo(User::class,'created_by');
    }
    public function scopeSearch($query,$search){
        return $query->where('name','like','%'.$search.'%')->get();
        
    }
    public function getNameAttribute($value)
    {
        return $this->attributes['name'] = ucfirst($value);
    }
    public function scopeSort($query)
    {

        return $query->orderby('created_at','desc');
        
    }
}
