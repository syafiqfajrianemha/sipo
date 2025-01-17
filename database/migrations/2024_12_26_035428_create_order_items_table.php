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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade'); // Relasi ke tabel orders
            $table->string('drug_id')->constrained('drugs')->onDelete('cascade');; // Nama obat
            $table->string('unit');
            $table->integer('initial_stock')->nullable()->default(0); // Stok awal
            $table->integer('acceptance')->nullable()->default(0); // Penerimaan
            $table->integer('inventory')->nullable()->default(0); // Persediaan
            $table->integer('usage')->nullable()->default(0); // Pemakaian
            $table->integer('remaining_stock')->nullable()->default(0); // Sisa stok
            $table->integer('optimum_stock')->nullable()->default(0); // Stok optimum
            $table->integer('request_quantity')->nullable()->default(0); // Permintaan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
