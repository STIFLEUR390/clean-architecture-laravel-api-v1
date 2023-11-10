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
        Schema::create('order_payments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('reference');
            $table->string('status')->default('pending');
            $table->string('channel')->default('cm.mobile');
            $table->string('channel_detail')->nullable();
            $table->text('description')->nullable();
            $table->text('payment_url')->nullable();
            $table->json('error')->nullable();
            $table->json('meta')->nullable();
            $table->foreignUuid('order_id')->constrained('orders')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_payments');
    }
};
