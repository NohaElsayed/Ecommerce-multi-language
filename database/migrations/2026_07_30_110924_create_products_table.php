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
             $table->id();
        $table->foreignId('category_id')->constrained();
        $table->foreignId('sub_category_id')->nullable()->constrained();
        $table->json('name');
        $table->json('description');
        $table->json('short_description')->nullable();
        $table->string('slug')->unique();
        $table->string('sku')->unique();
        $table->decimal('price', 10, 2);
        $table->decimal('sale_price', 10, 2)->nullable();
        $table->integer('stock')->default(0);
        $table->string('image')->nullable();
        $table->json('gallery')->nullable();
        $table->boolean('is_featured')->default(false);
        $table->boolean('is_active')->default(true);
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
