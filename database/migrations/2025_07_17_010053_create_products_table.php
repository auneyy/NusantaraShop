<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('deskripsi');
            $table->text('deskripsi_singkat')->nullable();
            $table->decimal('harga', 12, 2);
            $table->decimal('harga_jual', 12, 2)->nullable();
            $table->string('sku')->unique();
            $table->integer('stock_kuantitas')->default(0);
            $table->decimal('berat', 8, 2)->nullable();
            $table->json('dimensi')->nullable();
            $table->enum('status', ['active', 'inactive', 'out_of_stock'])->default('active');
            $table->boolean('is_featured')->default(false);
            $table->decimal('rating_rata', 3, 2)->default(0.00);
            $table->integer('total_reviews')->default(0);
            $table->integer('total_penjualan')->default(0);
            $table->json('meta_data')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};