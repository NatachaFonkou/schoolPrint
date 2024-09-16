<?php

namespace App\Models;

use App\Enums\EvaluationType;
use App\Enums\Semester;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    protected $fillable = ['evaluation_date', 'evaluation_type', 'weight', 'semester', 'subject_id'];

    protected $casts = [
        'evaluation_type' =>EvaluationType::class,
        'semester' => Semester::class,
    ];

    public function subject(){
        return $this->belongsTo(Subject::class);
    }

    // Relation vers les évaluations des étudiants
    public function studentEvaluations()
    {
        return $this->hasMany(StudentEvaluation::class);
    }

    // Récupérer les étudiants liés à une évaluation
    public function students()
    {
        return $this->hasManyThrough(Student::class, StudentEvaluation::class, 'evaluation_id', 'id', 'id', 'student_id');
    }


}
