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
   
    public function scopeSearch($query,array $value)
    {
        
       if($value==null)
       {
        return $query ;
       }
        elseif(isset($value['sort']))
        {
            if($value['sort']=='new')
            {
                return $query->orderby('created_at','desc');
            }
            elseif($value['sort']=='asc')
            {
               return $query->orderby('name', 'asc');
            }
            else
            {
               return $query->orderby('name', 'desc');
            }       
        }
        elseif(isset($value['search']))
        {
            return $query->where('name','like','%'.$value['search'].'%');          
        }
        
    }
    public function getNameAttribute($value)
    {
        
        return $this->attributes['name'] = ucfirst($value);
    }

    public function scopeVisibleto($query)
    {

        return $query->where('created_by',Auth::id());
    }
    public function scopeActive($query)
    {
       
        return $query->where('status',true);
    }


  
}
