<?php

use App\Enums\FulfillmentType;
use App\Enums\OrderChannel;
use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            // Nullable: anonymous walk-in (offline) orders have no customer account.
            $table->foreignId('customer_id')->nullable()->constrained('customers')->nullOnDelete();
            // Snapshot of the name on the receipt/cup at order time (kept even when
            // customer_id is set, so renaming the customer doesn't rewrite history).
            $table->string('customer_name');
            $table->string('status')->default(OrderStatus::Open->value);
            $table->string('channel')->default(OrderChannel::Offline->value);
            $table->string('fulfillment_type')->nullable();
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->string('payment_method')->nullable();
            $table->jsonb('special_instructions')->nullable();
            $table->timestampsTz();

            $table->index('customer_id');
            $table->index('status');
            $table->index('channel');
            $table->index('created_at');
        });

        // Domain integrity: statuses / payment methods must match our PHP enums.
        DB::statement(
            'ALTER TABLE orders ADD CONSTRAINT orders_status_check '
            .'CHECK (status IN ('.OrderStatus::sqlList().'))'
        );
        DB::statement(
            'ALTER TABLE orders ADD CONSTRAINT orders_payment_method_check '
            .'CHECK (payment_method IS NULL OR payment_method IN ('.PaymentMethod::sqlList().'))'
        );
        DB::statement(
            'ALTER TABLE orders ADD CONSTRAINT orders_channel_check '
            .'CHECK (channel IN ('.OrderChannel::sqlList().'))'
        );
        DB::statement(
            'ALTER TABLE orders ADD CONSTRAINT orders_fulfillment_type_check '
            .'CHECK (fulfillment_type IS NULL OR fulfillment_type IN ('.FulfillmentType::sqlList().'))'
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
