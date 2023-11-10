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
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('reference');
            $table->double('total')->default(0);
            $table->double('subtotal')->default(0);
            $table->decimal('tax')->default(0);
            $table->double('shipping')->default(0);
            $table->string('facture')->nullable();
            $table->string('status')->default('pending');
            $table->foreignUuid('billing_id')->constrained('addresses')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignUuid('shipping_id')->constrained('addresses')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
