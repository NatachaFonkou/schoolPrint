<?php

namespace App\Providers;


use App\Models\User;
use App\Policies\UserPolicy;

use App\Models\Result;
use App\Policies\ResultPolicy;

use App\Models\Student;
use App\Policies\StudentPolicy;

use App\Models\Teacher;
use App\Policies\TeacherPolicy;

use App\Models\GroupLeader;
use App\Policies\GroupLeaderPolicy;

use App\Models\Admin;
use App\Policies\AdminPolicy;

use App\Models\User;
use App\Policies\UserPolicy;

use App\Models\Course;
use App\Policies\CoursePolicy;

use App\Models\Cycle;
use App\Policies\CyclePolicy;

use App\Models\Program;
use App\Policies\ProgramPolicy;

use App\Models\Department;
use App\Policies\DepartmentPolicy;




use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Result::class => ResultPolicy::class,
        Student::class => StudentPolicy::class,
        Teacher::class => TeacherPolicy::class,
        GroupLeader::class => GroupLeaderPolicy::class,
        Admin::class => AdminPolicy::class,
        User::class => UserPolicy::class,
        Course::class => CoursePolicy::class,
        Cycle::class => CyclePolicy::class,
        Program::class => ProgramPolicy::class,
        Department::class => DepartmentPolicy::class,
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}