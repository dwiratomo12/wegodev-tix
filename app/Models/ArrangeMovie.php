<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArrangeMovie extends Model
{
    use HasFactory;

    protected $table = 'arrange_movie';

    public function movies()
    {
        return $this->hasMany('App\Models\Movie', 'id', 'movie_id');
    }
}