<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $fillable=[
        'title',
        'director',
        'duration',
        'classification',
        'image',
        'start_exhibition',
        'finish_exhibition',
        'token'
    ];
}