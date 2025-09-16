<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->string('name');                 // Nama lengkap pengirim
            $table->string('phone')->nullable();    // Nomor telepon (optional)
            $table->string('email');                // Email pengirim
            $table->string('subject')->nullable();  // Subjek pesan
            $table->text('message');                // Isi pesan
            $table->boolean('is_read')->default(0); // 0 = belum dibaca, 1 = sudah dibaca
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
