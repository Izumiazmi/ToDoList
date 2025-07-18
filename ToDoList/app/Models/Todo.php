<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    // App\Models\Todo.php
protected $fillable = ['text', 'date', 'is_completed'];

}
