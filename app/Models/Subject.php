<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = ['name', 'code', 'teacher_id'];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    // Relation avec les classrooms via une table pivot 'classroom_subject'
    public function classrooms()
    {
        return $this->belongsToMany(Classroom::class, 'classroom_subject');
    }

    // Relation avec les évaluations
    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }

    // Relation avec les étudiants via les évaluations
    public function students()
    {
        return $this->hasManyThrough(Student::class, Evaluation::class, 'subject_id', 'id', 'id', 'student_id');
    }
}
