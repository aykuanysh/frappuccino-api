<?php

use App\Enums\OrderStatus;
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
        Schema::create('order_status_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->string('previous_status')->nullable();
            $table->string('new_status');
            $table->timestampTz('changed_at')->useCurrent();

            $table->index('order_id');
            $table->index('changed_at');
        });

        DB::statement(
            'ALTER TABLE order_status_history ADD CONSTRAINT osh_previous_status_check '
            .'CHECK (previous_status IS NULL OR previous_status IN ('.OrderStatus::sqlList().'))'
        );
        DB::statement(
            'ALTER TABLE order_status_history ADD CONSTRAINT osh_new_status_check '
            .'CHECK (new_status IN ('.OrderStatus::sqlList().'))'
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_status_history');
    }
};
