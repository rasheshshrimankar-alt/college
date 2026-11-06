<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notices', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->string('category')->default('general'); // general, exam, fee, event, holiday
            $table->enum('target', ['all', 'students', 'faculty', 'admin'])->default('all');
            $table->string('attachment')->nullable();
            $table->date('publish_date');
            $table->date('expiry_date')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->boolean('is_important')->default(false);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });

        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->string('image')->nullable();
            $table->string('category')->default('general');
            $table->string('slug')->unique();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->boolean('is_featured')->default(false);
            $table->integer('views')->default(0);
            $table->enum('status', ['draft', 'published', 'archived'])->default('published');
            $table->timestamps();
        });

        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('venue')->nullable();
            $table->datetime('start_datetime');
            $table->datetime('end_datetime')->nullable();
            $table->string('organizer')->nullable();
            $table->string('category')->default('cultural');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->enum('status', ['upcoming', 'ongoing', 'completed', 'cancelled'])->default('upcoming');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
        Schema::dropIfExists('news');
        Schema::dropIfExists('notices');
    }
};
