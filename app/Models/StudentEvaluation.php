<?php

namespace App\Models;

use App\Enums\Appreciation;
use Illuminate\Database\Eloquent\Model;

class StudentEvaluation extends Model
{
    protected $fillable = ['note', 'student_id', 'evaluation_id', 'appreciation'];

    protected $casts = [
        'appreciation' => Appreciation::class
    ];
    public function student(){
        return $this->belongsTo(Student::class);
    }
    public function evaluation(){
        return $this->belongsTo(Evaluation::class);
    }
}
