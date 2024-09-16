<?php

namespace App\Models;

use App\Enums\Appreciation;
use Illuminate\Database\Eloquent\Model;

class StudentEvaluation extends Model
{
    protected $fillable = ['note', 'student_id', 'evaluation_id', 'classroom_id', 'appreciation'];

    protected $casts = [
        'appreciation' => Appreciation::class
    ];

    // Relation vers les étudiants
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // Relation vers les évaluations
    public function evaluation()
    {
        return $this->belongsTo(Evaluation::class);
    }

    // Relation vers les classes
    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }
}
