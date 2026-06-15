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
        Schema::create('menu_item_ingredients', function (Blueprint $table) {
            $table->foreignId('menu_item_id')->constrained('menu_items')->cascadeOnDelete();
            // Restrict: an ingredient still used in a recipe cannot be deleted.
            $table->foreignId('inventory_id')->constrained('inventory')->restrictOnDelete();
            // How much of the ingredient one unit of the menu item consumes.
            $table->decimal('quantity', 12, 2);
            $table->timestampsTz();

            $table->primary(['menu_item_id', 'inventory_id']);
            $table->index('inventory_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_item_ingredients');
    }
};
