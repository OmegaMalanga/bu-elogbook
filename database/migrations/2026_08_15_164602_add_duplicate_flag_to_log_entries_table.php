<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('log_entries', function (Blueprint $table) {
            $table->boolean('flagged_duplicate')->default(false)->after('status');
            $table->foreignId('similar_to_log_entry_id')
                ->nullable()
                ->after('flagged_duplicate')
                ->constrained('log_entries')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('log_entries', function (Blueprint $table) {
            $table->dropConstrainedForeignId('similar_to_log_entry_id');
            $table->dropColumn('flagged_duplicate');
        });
    }
};