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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('document_number'); // Nomor dokumen
            $table->string('unit_name'); // Nama unit
            $table->string('report_month'); // Bulan pelaporan
            $table->string('request_month'); // Bulan permintaan
            $table->date('input_date'); // Tanggal input
            $table->enum('status', ['unverified', 'verified', 'done'])->default('unverified');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
