<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConseilDecision extends Model
{
    protected $fillable = ['name'];
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
