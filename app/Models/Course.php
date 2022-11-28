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
  
    public function enrollments()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('user_id')
            ->withTimestamps()
            ->using(CourseUser::class);

    }
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
    
    public function scopeVisibleTo($query)
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
        return $query->visibleto()->get() ;
       }
        elseif(isset($value['order']))
        {
            if ($value['order'] == 'asc') 
            {
                 return $query->orderby('title', 'asc')
                    ->VisibleTo()->get();
            } 
            elseif ($value['order'] == 'new') 
            {
             return $query->orderby('created_at', 'desc')
                ->visibleto()->get();
            } 
            else
            {
                return $query->orderby('title', 'desc')
                    ->visibleto()->get();
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
                    ->visibleto()->get();             
        }
        elseif(isset($value['level']))
        {
            return $query->where('level_id', $value['level'])
            ->Visibleto()->get();
        }
        elseif(isset($value['sort']))
        {
            return $query->where('category_id', $value['sort'])
                ->visibleto()->get();
        }   
        
    }
}
