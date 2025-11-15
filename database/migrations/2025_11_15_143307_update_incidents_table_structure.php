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
            // Supprimer les contraintes de clé étrangère existantes si elles existent
            if (Schema::hasColumn('incidents', 'category_id')) {
                $table->dropForeign(['category_id']);
            }
            
            // Supprimer les colonnes existantes si elles existent
            $columnsToDrop = [];
            
            if (Schema::hasColumn('incidents', 'status')) {
                $columnsToDrop[] = 'status';
            }
            
            if (Schema::hasColumn('incidents', 'votes_count')) {
                $columnsToDrop[] = 'votes_count';
            }
            
            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
            
            // Ajouter les nouvelles colonnes si elles n'existent pas déjà
            if (!Schema::hasColumn('incidents', 'title')) {
                $table->string('title');
            }
            
            if (!Schema::hasColumn('incidents', 'location')) {
                $table->text('location');
            }
            
            if (!Schema::hasColumn('incidents', 'category_id')) {
                $table->foreignId('category_id')->constrained()->onDelete('cascade');
            } else {
                // Recréer la contrainte de clé étrangère
                $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            }
            
            if (!Schema::hasColumn('incidents', 'status_id')) {
                $table->foreignId('status_id')->default(1)->constrained();
            }
            
            if (!Schema::hasColumn('incidents', 'slug')) {
                $table->string('slug')->unique();
            }
            
            if (!Schema::hasColumn('incidents', 'is_anonymous')) {
                $table->boolean('is_anonymous')->default(false);
            }
            
            if (!Schema::hasColumn('incidents', 'deleted_at')) {
                $table->softDeletes();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('incidents', function (Blueprint $table) {
            // Recréer les colonnes supprimées si elles n'existent pas
            if (!Schema::hasColumn('incidents', 'status')) {
                $table->enum('status', ['received', 'in_progress', 'resolved'])->default('received');
            }
            
            if (!Schema::hasColumn('incidents', 'votes_count')) {
                $table->unsignedInteger('votes_count')->default(0);
            }
            
            // Supprimer les colonnes ajoutées si elles existent
            $columnsToDrop = [];
            
            if (Schema::hasColumn('incidents', 'title')) {
                $columnsToDrop[] = 'title';
            }
            
            if (Schema::hasColumn('incidents', 'location')) {
                $columnsToDrop[] = 'location';
            }
            
            if (Schema::hasColumn('incidents', 'status_id')) {
                $columnsToDrop[] = 'status_id';
                $table->dropForeign(['status_id']);
            }
            
            if (Schema::hasColumn('incidents', 'slug')) {
                $columnsToDrop[] = 'slug';
            }
            
            if (Schema::hasColumn('incidents', 'is_anonymous')) {
                $columnsToDrop[] = 'is_anonymous';
            }
            
            if (Schema::hasColumn('incidents', 'deleted_at')) {
                $columnsToDrop[] = 'deleted_at';
            }
            
            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
            
            // Ne pas supprimer category_id car c'est une clé étrangère nécessaire
            // pour les relations existantes
        });
    }
};
