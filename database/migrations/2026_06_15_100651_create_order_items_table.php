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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            // Restrict: a menu item that has already been ordered cannot be hard
            // deleted, so historical orders keep referential integrity.
            $table->foreignId('menu_item_id')->constrained('menu_items')->restrictOnDelete();
            $table->integer('quantity');
            // Price captured at order time, independent of later menu price changes.
            $table->decimal('price_at_order', 10, 2);
            $table->jsonb('customizations')->nullable();
            $table->timestampsTz();

            $table->index(['order_id', 'menu_item_id']);
            $table->index('menu_item_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
