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
        Schema::create('incidents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('citizen_id')->constrained('users');
            $table->enum('type', ['accident', 'route_hole', 'fire', 'electricity', 'theft', 'other']);
            $table->text('description');
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->string('photo')->nullable();
            $table->string('video')->nullable();
            $table->enum('status', ['received', 'in_progress', 'resolved'])->default('received');
            $table->unsignedInteger('votes_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incidents');
    }
};
