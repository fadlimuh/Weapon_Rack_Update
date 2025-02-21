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
        Schema::create('personnels', function (Blueprint $table) {
            $table->string('personnel_id', 255)->primary()->unique();
            $table->string('loadCellID', 255)->required();
            $table->string('nokartu', 255)->unique()->required();
            $table->string('nama', 255)->required();
            $table->string('pangkat', 255)->required();
            $table->string('nrp', 255)->unique()->required();
            $table->string('jabatan', 255)->required();
            $table->string('kesatuan', 255)->required();

            $table->foreign('loadCellID')->references('loadCellID')->on('weapons');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personnels');
        Schema::table('personnels', function (Blueprint $table) {
            $table->dropForeign(['loadCellID']);
            $table->dropColumn('loadCellID');
        });
    }
};
