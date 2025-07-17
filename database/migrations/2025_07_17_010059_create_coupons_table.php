<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->string('name');
            $table->text('deskripsi')->nullable();
            $table->enum('type', ['percentage', 'fixed']);
            $table->decimal('harga', 10, 2);
            $table->decimal('minimum_amount', 10, 2)->nullable();
            $table->integer('limit_penggunaan')->nullable();
            $table->integer('used_count')->default(0);
            $table->datetime('valid_dari');
            $table->datetime('valid_sampai');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('coupons');
    }
};