<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::dropIfExists('coupons');
    }

    public function down()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->string('name');
            $table->text('deskripsi')->nullable();
            $table->enum('type', ['fixed', 'percentage']); // Adjust enum values as needed
            $table->decimal('harga', 10, 2);
            $table->decimal('minimum_amount', 10, 2)->nullable();
            $table->integer('limit_penggunaan')->nullable();
            $table->integer('used_count')->default(0);
            $table->dateTime('valid_dari');
            $table->dateTime('valid_sampai');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }
};