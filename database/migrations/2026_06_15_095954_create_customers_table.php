<?php

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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            // Login identity for online (app) customers. Nullable so cashiers can
            // create phone-only loyalty customers without an app account.
            $table->string('email')->nullable()->unique();
            $table->timestampTz('email_verified_at')->nullable();
            $table->string('phone')->nullable()->unique();
            // Nullable: phone-only / cashier-created customers have no password.
            $table->string('password')->nullable();
            // Customer-level preferences (favorite size, milk, loyalty tier, ...).
            $table->jsonb('preferences')->nullable();
            $table->rememberToken();
            $table->timestampsTz();
        });

        // A customer record must be reachable by at least one identity.
        DB::statement(
            'ALTER TABLE customers ADD CONSTRAINT customers_identity_check '
            .'CHECK (email IS NOT NULL OR phone IS NOT NULL)'
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
