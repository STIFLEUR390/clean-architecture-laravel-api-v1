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
        Schema::create('addresses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->enum('civility', ['M.', 'Mme', 'Mlle'])->default('M.');
            $table->string('name');
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('line1')->nullable();
            $table->string('line2')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('state')->nullable();
            $table->boolean('personnal')->default(true);
            $table->foreignUuid('customer_id')->constrained('customers')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
