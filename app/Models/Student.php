<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Department;
use App\Models\Program;
use App\Models\Cycle;
use App\Models\Result;

class Student extends Model
{
    protected $fillable = ['user_id', 'matricule', 'department_id', 'program_id', 'cycle_id', 'level'];

    /** @use HasFactory<\Database\Factories\StudentFactory> */
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function cycle()
    {
        return $this->belongsTo(Cycle::class);
    }

    public function results()
    {
        return $this->hasMany(Result::class);
    }
}
