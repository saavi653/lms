<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory,Sluggable,SoftDeletes;
    protected $fillable = [
        'name',
        'status',
        'created_by',
        'slug'
    ];
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['name']
            ]
        ];
    }
    public function user() {
      
        return $this->belongsTo(User::class,'created_by');
    }
    public function scopeSearch($query,$search){

        return $query->where('name','like','%'.$search.'%');
        
    }
    public function getNameAttribute($value)
    {
        
        return $this->attributes['name'] = ucfirst($value);
    }
    public function scopeSort($query)
    {

        return $query->orderby('created_at','desc');
        
    }
    public function scopeVisible($query)
    {

        return $query->where('created_by',Auth::id());
    }
    public function scopeActive($query)
    {
       
        return $query->where('status',true);
    }


  
}
