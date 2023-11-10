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
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sku')->nullable();
            $table->text('short_description')->nullable();
            $table->text('description')->nullable();
            $table->double('price', 15, 3, true)->nullable();
            $table->enum('stock', ['instock', 'outstock'])->default('instock');
            $table->enum('status', ['publish', 'scheduled', 'inactive'])->default('publish');
            $table->dateTime('date_to_publish')->nullable();
            $table->unsignedBigInteger('qty');
            $table->string('img')->default('https://robohash.org/foo.png');
            $table->foreignUuid('category_id')->constrained('categories')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
