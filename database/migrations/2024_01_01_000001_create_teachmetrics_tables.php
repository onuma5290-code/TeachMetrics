<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration 
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id('student_id');
            $table->string('student_code', 50)->unique();
            $table->string('password');
            $table->string('fullname', 150);
            $table->string('department', 150);
            $table->string('classroom', 50);
            $table->timestamps();
        });

        Schema::create('teachers', function (Blueprint $table) {
            $table->id('teacher_id');
            $table->string('teacher_code', 50)->unique();
            $table->string('password');
            $table->string('fullname', 150);
            $table->timestamps();
        });

        Schema::create('teacher_subjects', function (Blueprint $table) {
            $table->id('subject_id');
            $table->unsignedBigInteger('teacher_id');
            $table->string('subject_name', 150);
            $table->string('department', 50);
            $table->string('classroom', 50);
            $table->timestamps();

        // Foreign key usually linked to teachers, but let's check if the code relies on strict FK
        // In the SQL dump, there were no explicit constraints, but good practice to add if possible.
        // For now, I will stick to the SQL structure to avoid breaking legacy logic if any.
        });

        Schema::create('evaluations', function (Blueprint $table) {
            $table->id('evaluation_id');
            $table->unsignedBigInteger('subject_id');
            $table->unsignedBigInteger('student_id');
            $table->integer('question_1');
            $table->integer('question_2');
            $table->integer('question_3');
            $table->integer('question_4');
            $table->integer('question_5');
            $table->integer('question_6');
            $table->integer('question_7');
            $table->integer('question_8');
            $table->integer('question_9');
            $table->integer('question_10');
            $table->integer('question_11');
            $table->integer('question_12');
            $table->integer('question_13');
            $table->integer('question_14');
            $table->integer('question_15');
            $table->string('evaluation_note', 255)->nullable();
            $table->timestamps();
            
            // Prevent duplicate evaluations: each student can evaluate each subject only once
            $table->unique(['student_id', 'subject_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluations');
        Schema::dropIfExists('teacher_subjects');
        Schema::dropIfExists('teachers');
        Schema::dropIfExists('students');
    }
};
