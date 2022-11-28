<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Spatie\WelcomeNotification\ReceivesWelcomeNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Relations\Concerns\SupportsDefaultModels;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes ,ReceivesWelcomeNotification,Sluggable;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
   
    protected $fillable = [
        'first_name' ,
        'last_name' ,
        'slug' ,
        'email',
        'created_by',
        'gender',
        'phone',
        'password',
        'image'  ,
        'email_status',
        'status',
        'role_id'
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['first_name','last_name']
            ]
        ];
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Scope's
    public function scopeEmployee($query)
    {
        return $query->where('role_id', Role::EMPLOYEE);
    }

    public function scopeActive($query) 
    {
        return $query->where('status', true);
    }

    public function scopeVisibleTo($query)
    {
        return $query->where('created_by', Auth::id());
    }

    public function scopeSearch($query,array $value)
    {
        
       if ($value==null)
       {
            return $query ;
       }
        elseif (isset($value['sort']))
        {
            if ($value['sort']=='new')
            {
                return $query->orderby('created_at', 'desc');  
            }
            elseif ($value['sort']=='asc')
            {
                return $query->orderby('first_name', 'asc');
            }
            else
            {
                return $query->orderby('first_name', 'desc');
            }    
        }
        elseif (isset($value['role']))
        {
            return $query->where('role_id',$value['role']);
        }
        elseif (isset($value['search']))
        {
            return $query->where('first_name','LIKE','%'.$value['search'].'%')
                ->orwhere('email','LIKE','%'.$value['search'].'%');             
        }
        
    }

    // Relationship's

    // a user can create multiple course's.
    public function courses() 
    {
        return $this->hasMany(Course::class);
    }

    public function enrollments()
    {
        return $this->belongsToMany(Course::class)
            ->withPivot('id')
            ->withTimestamps()
            ->using(CourseUser::class);
    }


    // Attribute's

    public function getFullNameAttribute()
    {
        return ucfirst($this->first_name)." ".ucfirst($this->last_name);
    }

    public function getIsAdminAttribute()
    {
        return $this->role_id==Role::ADMIN;
    }

    public function getIsEmployeeAttribute()
    {
        return $this->role_id==Role::EMPLOYEE;
    }

    public function getIsTrainerAttribute()
    {
        return $this->role_id==Role::TRAINER;
    }

    public function role()
    {
        return $this->belongsTo(Role::class,);
    }
}
