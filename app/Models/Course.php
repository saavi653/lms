<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory, Sluggable;

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
            ->orwhere('description', 'LIKE', '%' . $search . '%')->get();
    }

    public function scopeFilter($query, $category)
    {

        return $query->where('category_id', $category)->get();
    }
    public function scopeLevelfind($query, $level)
    {

        return $query->where('level_id', $level)->get();
    }
    public function scopeSort($query, $order)
    {

        if ($order == 'asc') {

            return $query->orderby('title', 'asc')->get();
        } elseif ($order == 'new') {

            return $query->orderby('created_at', 'desc')->get();
        } else {

            return $query->orderby('title', 'desc')->get();
        }
    }
    public function scopeCategorygroup($query, $order)
    {

        return $query->where('category_id', $order)->get();
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
