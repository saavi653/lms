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
  
    public function scopeSearch($query,array $value)
    {
        
       if($value==null)
       {
        return $query ;
       }
        elseif(isset($value['sort']))
        {
            return $query->orderby('created_at','desc');  
        }
        elseif(isset($value['role']))
        {
            return $query->where('role_id',$value['role']);
        }
        elseif(isset($value['search']))
        {
            return $query->where('first_name','LIKE','%'.$value['search'].'%')
                ->orwhere('email','LIKE','%'.$value['search'].'%');             
        }
        
    }

    public function scopeVisible($query)
    {
        return $query->where('created_by',Auth::id());
    }

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
}
