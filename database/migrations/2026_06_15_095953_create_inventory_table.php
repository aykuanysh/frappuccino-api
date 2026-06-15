<?php

use App\Enums\UnitType;
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
        Schema::create('inventory', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('quantity', 12, 2)->default(0);
            $table->string('unit')->default(UnitType::Units->value);
            $table->decimal('price', 10, 2)->default(0);
            $table->decimal('reorder_level', 12, 2)->nullable();
            $table->timestampsTz();

            $table->index('quantity');
            $table->index('price');
        });

        DB::statement(
            'ALTER TABLE inventory ADD CONSTRAINT inventory_unit_check '
            .'CHECK (unit IN ('.UnitType::sqlList().'))'
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory');
    }
};
