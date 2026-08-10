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
            $table->string('pending_company_supervisor_email')->nullable()->after('pending_company_supervisor_name');
            $table->string('company_supervisor_invite_token')->nullable()->unique()->after('pending_company_supervisor_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('internships', function (Blueprint $table) {
            $table->dropColumn(['pending_company_supervisor_email', 'company_supervisor_invite_token']);
        });
    }
};