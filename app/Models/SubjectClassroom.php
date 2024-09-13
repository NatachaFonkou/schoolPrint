<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubjectClassroom extends Model
{
    protected $fillable =['subject_id', 'classroom_id'];
    public function subject(){
        return $this->belongsTo(Subject::class);
    }
    public function classroom(){
        return $this->belongsTo(Classroom::class);
    }
}
