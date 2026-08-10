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
        Schema::table('internships', function (Blueprint $table) {
            $table->unsignedTinyInteger('year_of_study')->nullable()->after('department_id');
            $table->string('pending_company_supervisor_name')->nullable()->after('company_supervisor_id');
            $table->string('pending_university_supervisor_name')->nullable()->after('university_supervisor_id');
            $table->date('start_date')->nullable()->change();
            $table->date('end_date')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('internships', function (Blueprint $table) {
            $table->dropColumn(['year_of_study', 'pending_company_supervisor_name', 'pending_university_supervisor_name']);
            $table->date('start_date')->nullable(false)->change();
            $table->date('end_date')->nullable(false)->change();
        });
    }
};
