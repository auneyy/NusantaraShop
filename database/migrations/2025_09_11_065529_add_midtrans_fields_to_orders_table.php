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
        Schema::table('orders', function (Blueprint $table) {
            // Update payment_method enum to include midtrans
            $table->string('payment_method')->change(); // Change to string to avoid enum issues
            
            // Add new payment status options
            $table->string('payment_status')->change(); // Change to string to avoid enum issues
            
            // Add Midtrans specific fields
            $table->string('snap_token')->nullable()->after('payment_status');
            $table->string('midtrans_transaction_id')->nullable()->after('snap_token');
            $table->string('midtrans_payment_type')->nullable()->after('midtrans_transaction_id');
            $table->timestamp('payment_completed_at')->nullable()->after('midtrans_payment_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['snap_token', 'midtrans_transaction_id', 'midtrans_payment_type', 'payment_completed_at']);
            
            // Revert back to enum if needed
            $table->enum('payment_method', ['bank_transfer', 'cod', 'ewallet'])->change();
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending')->change();
        });
    }
};