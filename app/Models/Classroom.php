<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    protected $fillable = ['name', 'code', 'option_id'];

    public function students()
    {
        return $this->hasMany(Student::class);
    }
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'classroom_subject');
    }

    public function option(){
        return $this->belongsTo(Option::class);
    }
}
