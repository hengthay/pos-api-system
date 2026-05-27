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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string("invoice_no", 30)->unique();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->decimal("subtotal", 8, 2);
            $table->decimal("discount", 8, 2)->default(0);
            $table->decimal("tax", 8, 2)->default(0);
            $table->decimal("total", 8, 2);
            $table->decimal('paid_amount', 8, 2)->default(0);
            $table->enum("payment_status", ["unpaid", "partial", "paid", "refunded"])->default("unpaid");
            $table->dateTime("sale_date");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
