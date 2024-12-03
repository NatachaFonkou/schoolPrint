<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class)->constrained()->cascadeOnDelete();
            $table->string('matricule');
            $table->foreignIdFor(\App\Models\Department::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\Program::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\Cycle::class)->constrained()->cascadeOnDelete();
            $table->string('level');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
