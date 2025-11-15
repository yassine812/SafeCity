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
        Schema::table('incidents', function (Blueprint $table) {
            // Remove old media columns
            $table->dropColumn(['photo', 'video']);
            
            // Add media JSON column
            $table->json('media')->nullable()->after('description');
            
            // Update status enum to match our application needs
            $table->enum('status', ['pending', 'in_progress', 'resolved', 'rejected'])
                ->default('pending')
                ->change();
                
            // Add category_id foreign key
            $table->foreignId('category_id')
                ->after('citizen_id')
                ->constrained()
                ->onDelete('restrict');
                
            // Add title column
            $table->string('title')->after('category_id');
            
            // Add location text field
            $table->string('location')->after('longitude');
            
            // Rename citizen_id to user_id for consistency
            $table->renameColumn('citizen_id', 'user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('incidents', function (Blueprint $table) {
            // Revert the changes
            $table->string('photo')->nullable();
            $table->string('video')->nullable();
            
            $table->dropColumn('media');
            $table->dropColumn('title');
            $table->dropColumn('location');
            
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
            
            $table->enum('status', ['received', 'in_progress', 'resolved'])
                ->default('received')
                ->change();
                
            $table->renameColumn('user_id', 'citizen_id');
        });
    }
};
