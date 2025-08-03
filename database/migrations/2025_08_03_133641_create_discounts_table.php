<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->integer('percentage')->default(0);
            $table->decimal('fixed_amount', 12, 2)->nullable();
            $table->enum('type', ['percentage', 'fixed'])->default('percentage');
            $table->datetime('start_date');
            $table->datetime('end_date');
            $table->boolean('is_active')->default(true);
            $table->string('banner_color')->default('#422D1C');
            $table->string('text_color')->default('#ffffff');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('discounts');
    }
};