<?php

use App\Enums\Semester;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\EvaluationType;


class CreateEvaluationsTable extends Migration
{
    public function up()
    {
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->date('evaluation_date');
            $table->enum('evaluation_type', array_column(EvaluationType::cases(), 'value'))
                ->default(EvaluationType::CC->value);
            $table->decimal('weight', 5, 2);
            $table->enum('semester', array_column(Semester::cases(), 'value'))->default(Semester::currentSemester());
            $table->unsignedBigInteger('subject_id');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('evaluations');
    }
}

