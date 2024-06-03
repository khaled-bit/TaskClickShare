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
        Schema::create('product_values', function (Blueprint $table) {

            $table->id();
            $table->foreignId('product_id')->constrained('products');
            $table->foreignId('attribute_id')->constrained('attributes');
            $table->string('value');
            $table->foreignId('country_id')->constrained('countries');
            $table->timestamps();

            $table->unique(['product_id', 'country_id', 'attribute_id'], 'product_country_attribute_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_values');
    }
};
