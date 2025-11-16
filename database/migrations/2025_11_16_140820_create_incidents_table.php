<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
     Schema::create('incidents', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
    $table->string('title');
    $table->text('description');

    $table->string('city');
    $table->string('address_line1');
    $table->string('postal_code');
    $table->string('country')->default('Tunisia');

    $table->unsignedInteger('votes_count')->default(0);

    $table->enum('status', [
        'nouveau', 'en_attente', 'en_cours', 'resolu', 'ferme'
    ])->default('nouveau');

    $table->timestamps();
});


    }

    public function down(): void
    {
        Schema::dropIfExists('incidents');
    }
};
