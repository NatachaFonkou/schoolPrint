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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->integer('credits');
            $table->foreignIdFor(\App\Models\Department::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\Program::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\Teacher::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
