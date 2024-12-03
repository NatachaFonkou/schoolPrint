<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    protected $fillable = ['name', 'head', 'status'];

    /** @use HasFactory<\Database\Factories\DepartmentFactory> */
    use HasFactory;

    public function programs():HasMany
    {
        return $this->hasMany(Program::class);
    }

    public function cycles():HasMany
    {
        return $this->hasMany(Cycle::class);
    }

    public function courses():HasMany
    {
        return $this->hasMany(Course::class);
    }

    public function teachers():HasMany
    {
        return $this->hasMany(Teacher::class);
    }

    public function students():HasMany
    {
        return $this->hasMany(Student::class);
    }

    public function groupLeaders():HasOne
    {
        return $this->hasOne(GroupLeader::class);
    }
}
