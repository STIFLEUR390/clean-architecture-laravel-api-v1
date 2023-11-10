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
        Schema::create('order_details', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->double('price', 15, 3, true)->default(0);
            $table->double('qty')->default(1);
            $table->double('total', 15, 3, true)->default(0);
            $table->foreignUuid('product_id')->nullable()->constrained('products')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignUuid('order_id')->constrained('orders')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
