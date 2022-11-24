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
    public function scopeSearch($query, $search)
    {
        return $query->where('title', 'LIKE', '%' . $search . '%')
            ->orwhere('description', 'LIKE', '%' . $search . '%');
    }

    public function scopeFilter($query, $category)
    {

        return $query->where('category_id', $category)->get();
    }
    public function scopeLevelfind($query, $level)
    {

        return $query->where('level_id', $level)
                ->where('user_id',Auth::id());
    }
    public function scopeSort($query, $order)
    {

        if ($order == 'asc') 
        {

            return $query->orderby('title', 'asc');
        } 
        elseif ($order == 'new') 
        {

            return $query->orderby('created_at', 'desc');
        } 
        else
        {

            return $query->orderby('title', 'desc')->get();
        }
    }
    public function scopeCategorygroup($query, $order)
    {

        return $query->where('category_id', $order);
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
}
