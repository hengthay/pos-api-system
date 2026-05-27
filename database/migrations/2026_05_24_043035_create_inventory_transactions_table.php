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
        Schema::create('inventory_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->nullable()->constrained('products')->nullOnDelete();
            $table->enum("transaction_type", ["sale", "purchase", "adjustment", "return", "damage"])->default("purchase");
            $table->integer("quantity");
            $table->foreignId("sale_id")->nullable()->constrained("sales")->nullOnDelete();
            $table->foreignId("purchase_id")->nullable()->constrained("purchases")->nullOnDelete();
            $table->text("notes")->nullable();
            $table->foreignId("created_by")->nullable()->constrained("users")->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_transactions');
    }
};
