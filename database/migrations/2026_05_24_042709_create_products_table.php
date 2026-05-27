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
            $table->string("product_name", 100);
            $table->string("product_code", 40)->unique();
            $table->string("brand", 100)->nullable();
            $table->decimal("cost_price", 8, 2);
            $table->decimal("selling_price", 8, 2);
            $table->integer('stock_quantity')->default(0);
            $table->text("image_url")->nullable();
            $table->text("description")->nullable();
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
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
