<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDiscountFieldsToOrderItemsTable extends Migration
{
    public function up()
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->decimal('original_price', 12, 2)->after('product_price')->default(0);
            $table->boolean('has_discount')->after('original_price')->default(false);
            $table->decimal('discount_percentage', 5, 2)->after('has_discount')->default(0);
        });
    }

    public function down()
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn(['original_price', 'has_discount', 'discount_percentage']);
        });
    }
}