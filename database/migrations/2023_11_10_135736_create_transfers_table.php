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
        Schema::create('transfers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('currency')->default('XAF');
            $table->double('amount', 15, 2, true)->default(0);
            $table->string('reference');
            $table->string('transaction_id')->nullable();
            $table->string('channel')->default('cm.mobile');
            $table->string('channel_detail')->nullable();
            $table->string('beneficiary')->nullable();
            $table->text('description')->nullable();
            $table->text('payment_url')->nullable();
            $table->string('status')->nullable();
            $table->json('error')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfers');
    }
};
