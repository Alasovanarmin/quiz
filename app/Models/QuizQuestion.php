<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function answers()
    {
        return $this->hasMany(QuestionAnswer::class,'question_id','id');
    }
    public function answers_for_join_page()
    {
        return $this->hasMany(QuestionAnswer::class,'question_id','id')
            ->select('id','question_id','answer');
    }
}
