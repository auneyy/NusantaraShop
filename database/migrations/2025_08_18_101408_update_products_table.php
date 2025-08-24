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
        Schema::table('products', function (Blueprint $table) {
            // Ubah enum status
            $table->enum('status', ['tersedia', 'habis', 'pre-order'])
                  ->default('tersedia')
                  ->change();

            // Tambahkan kolom baru
            $table->integer('quantity')->default(0)->after('sku');
            $table->string('size', 20)->nullable()->after('quantity');

            // Hapus kolom deskripsi_singkat
            if (Schema::hasColumn('products', 'deskripsi_singkat')) {
                $table->dropColumn('deskripsi_singkat');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Kembalikan status enum lama
            $table->enum('status', ['active', 'inactive', 'out_of_stock'])
                  ->default('active')
                  ->change();

            // Hapus kolom baru
            $table->dropColumn(['quantity', 'size']);

            // Tambahkan kembali deskripsi_singkat
            $table->text('deskripsi_singkat')->nullable()->after('deskripsi');
        });
    }
};
