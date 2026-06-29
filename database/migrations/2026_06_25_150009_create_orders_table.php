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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->dateTime('order_date');
            $table->date('estimated_finish_at')->nullable();
            $table->enum('laundry_status', [
                'Pending Confirmation',
                'Queued',
                'Washing',
                'Ironing',
                'Completed',
                'Picked Up',
            ])->default('Pending Confirmation');
            $table->enum('payment_status', [
                'Unpaid',
                'Paid',
            ])->default('Unpaid');
            $table->decimal('total_price', 10, 2)->default(0);
            $table->text('customer_note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
