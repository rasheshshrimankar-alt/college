<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('students', 'public_id')) {
            Schema::table('students', function (Blueprint $table) {
                $table->uuid('public_id')->nullable()->unique();
            });
        }

        DB::table('students')->whereNull('public_id')->orderBy('id')->chunkById(100, function ($students) {
            foreach ($students as $student) {
                DB::table('students')->where('id', $student->id)->update([
                    'public_id' => (string) Str::uuid(),
                ]);
            }
        });
    }

    public function down(): void
    {
        if (Schema::hasColumn('students', 'public_id')) {
            Schema::table('students', function (Blueprint $table) {
                $table->dropUnique(['public_id']);
                $table->dropColumn('public_id');
            });
        }
    }
};
