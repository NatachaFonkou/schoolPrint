<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    protected $fillable = ['name', 'code', 'option_id'];

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'classroom_subject');
    }

    public function option(){
        return $this->belongsTo(Option::class);
    }

    // Relation avec les étudiants via la table pivot student_classroom
    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_classroom')
            ->withPivot('start_date', 'end_date')
            ->withTimestamps();
    }
}
