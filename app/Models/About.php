<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class About extends Model
{
    protected $table = 'about';
    protected $fillable = [
        'email',
        'phone',
        'summary',
        'photo',
        'instagram',
        'facebook',
        'linkedin',
        'github',
    ];

}
