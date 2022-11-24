<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Course extends Model
{
    use HasFactory, Sluggable;

    CONST PUBLISH=1;
    CONST ARCHIEVE=2;
    CONST DRAFT=3;

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['title']
            ]
        ];
    }
    protected $fillable = [
        'title',
        'description',
        'category_id',
        'level_id',
        'certificate',
        'user_id',
        'status_id'
    ];
    public function units()
    {
        return $this->belongsToMany(Unit::class, 'course_units');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    public function scopeVisible($query)
    {
        return $query->where('user_id',Auth::id());
    }
   
    public function status()
    {

        return $this->belongsTo(Status::class);
    }
    public function level()
    {

        return $this->belongsTo(Level::class);
    }
    public function scopeSearch($query,array $value)
    {
        
       if($value==null)
       {
        return $query->visible()->get() ;
       }
        elseif(isset($value['order']))
        {
            if ($value['order'] == 'asc') 
            {
                 return $query->orderby('title', 'asc')
                    ->visible()->get();
            } 
            elseif ($value['order'] == 'new') 
            {
             return $query->orderby('created_at', 'desc')
                ->visible()->get();
            } 
            else
            {
                return $query->orderby('title', 'desc')
                    ->visible()->get();
            }  
        }
        elseif(isset($value['category']))
        {
            return $query->where('category_id', $value['category'])->get();
        }
        elseif(isset($value['search']))
        {
            return $query->where('title','LIKE','%'.$value['search'].'%')
                ->orwhere('description','LIKE','%'.$value['search'].'%')
                    ->visible()->get();             
        }
        elseif(isset($value['level']))
        {
            return $query->where('level_id', $value['level'])
            ->Visible()->get();
        }
        elseif(isset($value['sort']))
        {
            return $query->where('category_id', $value['sort'])
                ->visible()->get();
        }   
        
    }
}
