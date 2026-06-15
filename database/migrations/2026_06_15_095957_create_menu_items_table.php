<?php

use App\Enums\ItemSize;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->string('size')->nullable();
            $table->jsonb('metadata')->nullable();
            $table->timestampsTz();

            $table->index('category_id');
        });

        DB::statement(
            'ALTER TABLE menu_items ADD CONSTRAINT menu_items_size_check '
            .'CHECK (size IS NULL OR size IN ('.ItemSize::sqlList().'))'
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};
