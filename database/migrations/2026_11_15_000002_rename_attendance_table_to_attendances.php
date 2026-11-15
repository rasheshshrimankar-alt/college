<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * The original migration created "attendance" (singular), while
     * Eloquent's Attendance model queries "attendances" by convention.
     * Rename the existing table without dropping any student records.
     */
    public function up(): void
    {
        if (Schema::hasTable('attendance') && ! Schema::hasTable('attendances')) {
            Schema::rename('attendance', 'attendances');
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('attendances') && ! Schema::hasTable('attendance')) {
            Schema::rename('attendances', 'attendance');
        }
    }
};
