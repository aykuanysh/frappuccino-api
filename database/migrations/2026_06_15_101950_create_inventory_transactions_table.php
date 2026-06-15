<?php

use App\Enums\TransactionType;
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
        Schema::create('inventory_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventory_id')->constrained('inventory')->cascadeOnDelete();
            // The order that triggered usage, if any (restock/adjustment have none).
            $table->foreignId('order_id')->nullable()->constrained('orders')->nullOnDelete();
            $table->string('transaction_type');
            // Positive for restock, negative for usage/waste.
            $table->decimal('quantity_change', 12, 2);
            $table->string('reason')->nullable();
            $table->timestampTz('created_at')->useCurrent();

            $table->index('inventory_id');
            $table->index('order_id');
            $table->index('created_at');
        });

        DB::statement(
            'ALTER TABLE inventory_transactions ADD CONSTRAINT it_transaction_type_check '
            .'CHECK (transaction_type IN ('.TransactionType::sqlList().'))'
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_transactions');
    }
};
