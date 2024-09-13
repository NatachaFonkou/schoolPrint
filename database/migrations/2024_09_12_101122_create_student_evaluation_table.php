<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\Appreciation;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('student_evaluations', function (Blueprint $table) {
            $table->id();
            $table->decimal('note', 5, 2);
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('evaluation_id');
            $table->enum('appreciation', array_column(Appreciation::cases(), 'value'));
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('evaluation_id')->references('id')->on('evaluations')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_evaluation');
    }
};
