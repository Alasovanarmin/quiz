<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'updated_at' => "datetime:d.m.Y"
    ];

    public function questions()
    {
        return $this->hasMany(QuizQuestion::class, 'quiz_id','id');
    }

}
