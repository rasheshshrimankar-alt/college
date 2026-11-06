<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add course_id, department_id to assignments
        if (!Schema::hasColumn('assignments', 'course_id')) {
            Schema::table('assignments', function (Blueprint $table) {
                $table->unsignedBigInteger('course_id')->nullable()->after('faculty_id');
                $table->unsignedBigInteger('department_id')->nullable()->after('course_id');
                $table->integer('max_marks')->default(10)->after('department_id');
            });
        }

        // Add course_id, department_id, file_url, type to study_materials
        if (!Schema::hasColumn('study_materials', 'course_id')) {
            Schema::table('study_materials', function (Blueprint $table) {
                $table->unsignedBigInteger('course_id')->nullable()->after('faculty_id');
                $table->unsignedBigInteger('department_id')->nullable()->after('course_id');
                $table->string('type', 50)->nullable()->after('file_path');
                $table->string('file_url')->nullable()->after('type');
                $table->string('academic_year', 20)->nullable()->change();
                $table->string('file_path')->nullable()->change();
            });
        }
    }

    public function down(): void
    {
        // Reversals omitted for safety
    }
};
