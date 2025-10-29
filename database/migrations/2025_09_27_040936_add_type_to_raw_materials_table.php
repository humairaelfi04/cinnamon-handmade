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
        Schema::table('raw_materials', function (Blueprint $table) {
            // Kolom ini untuk membedakan 'Gelang/Kalung' atau 'Cincin'
            $table->string('accessory_type')->nullable()->after('name');

            // Kolom ini untuk membedakan bahan 'Kerangka' atau 'Batu Alam'
            $table->string('material_type')->default('Kerangka')->after('accessory_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('raw_materials', function (Blueprint $table) {
            $table->dropColumn(['accessory_type', 'material_type']);
        });
    }
};
