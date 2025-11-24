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
            $table->string('tracking_number')->nullable()->after('delivered_date');
            $table->string('current_tracking_status')->default('pending')->after('tracking_number');
            $table->json('tracking_history')->nullable()->after('current_tracking_status');
            $table->timestamp('estimated_delivery')->nullable()->after('tracking_history');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'tracking_number',
                'current_tracking_status',
                'tracking_history', 
                'estimated_delivery'
            ]);
        });
    }
};