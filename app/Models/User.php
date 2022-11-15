<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Spatie\WelcomeNotification\ReceivesWelcomeNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes ,ReceivesWelcomeNotification;
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

    public function role() {

        return $this->belongsTo(Role::class);
    }

    public function scopeSearch($query,$search)
    {
       
       return $query->where('first_name','LIKE','%'.$search.'%')
       ->orwhere('email','LIKE','%'.$search.'%')->get();
    }
    
    public function scopeSort($query)
    {

        return $query->orderby('created_at','desc');
        
    }

    public function scopeGroup($query,$role)
    {
        return $query->where('role_id',$role);
    }
    public function getFirstNameAttribute($value)
    {
        
        return $this->attributes['first_name'] = ucwords($value);
        
    }
    public function getFullNameAttribute()
    {

        return $this->first_name." ".$this->last_name;
    }
    public function getLastNameAttribute($value)
    {

        return $this->attributes['last_name'] = ucfirst($value);
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
