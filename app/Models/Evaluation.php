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


}
