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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique()->comment('Kode barang unik');
            $table->string('name')->comment('Nama barang');
            $table->string('category')->comment('Kategori barang');
            $table->integer('quantity')->default(0)->comment('Jumlah stok');
            $table->string('unit')->comment('Satuan (pcs, kg, liter, dll)');
            $table->decimal('price', 12, 2)->comment('Harga satuan');
            $table->string('supplier')->nullable()->comment('Nama supplier');
            $table->text('description')->nullable()->comment('Deskripsi barang');
            $table->timestamps();

            // Indexes untuk performa query
            $table->index('code');
            $table->index('category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
