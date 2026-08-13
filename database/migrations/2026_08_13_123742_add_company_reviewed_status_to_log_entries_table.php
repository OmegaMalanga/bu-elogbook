<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE log_entries MODIFY COLUMN status ENUM('draft','submitted','company_reviewed','reviewed') NOT NULL DEFAULT 'draft'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE log_entries MODIFY COLUMN status ENUM('draft','submitted','reviewed') NOT NULL DEFAULT 'draft'");
    }
};