<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $fillable = ['name'];

    public function classrooms()
    {
        return $this->hasMany(Classroom::class);
    }
}
