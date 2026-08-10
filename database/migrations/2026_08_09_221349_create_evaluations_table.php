<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('internship_id')->unique()->constrained()->onDelete('cascade');

            $table->unsignedTinyInteger('technical_competence')->nullable();
            $table->unsignedTinyInteger('punctuality_attendance')->nullable();
            $table->unsignedTinyInteger('initiative_problem_solving')->nullable();
            $table->unsignedTinyInteger('professionalism_work_ethic')->nullable();
            $table->unsignedTinyInteger('communication_teamwork')->nullable();
            $table->timestamp('company_supervisor_submitted_at')->nullable();

            $table->decimal('final_grade', 5, 2)->nullable();
            $table->timestamp('university_supervisor_submitted_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};