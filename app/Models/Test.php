<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'unit_id',
        'duration',
        'passing_score'
    ];
    public function lessons()
    {
        
        return $this->morphMany(Lesson::class, 'lessonable');
    }

}
