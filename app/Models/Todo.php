<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $fillable = ['title', 'completed'];

    // since we do not care about these fields eg we are not interested in returning them in the response to the frontend, we hide them like below
    protected $hidden = ['created_at', 'updated_at'];
}
