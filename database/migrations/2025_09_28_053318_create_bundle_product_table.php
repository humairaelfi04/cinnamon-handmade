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
        // Tabel ini menghubungkan produk yang bertipe 'bundle' dengan produk-produk isinya
        Schema::create('bundle_product', function (Blueprint $table) {
            // ID dari produk yang merupakan bundle
            $table->foreignId('bundle_id')->references('id')->on('products')->onDelete('cascade');

            // ID dari produk yang menjadi isi dari bundle
            $table->foreignId('product_id')->references('id')->on('products')->onDelete('cascade');

            // Menjadikan kombinasi keduanya unik untuk mencegah duplikat
            $table->primary(['bundle_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bundle_product');
    }
};
