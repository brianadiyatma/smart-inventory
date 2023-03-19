<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMStorageLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('m_storage_levels', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('level_name')->nullable();
        //     $table->string('plant_code')->index()->nullable();
        //     $table->foreign('plant_code')->references('plant_code')->on('sap_m_plants');
        //     $table->string('storloc_code')->index()->nullable();
        //     $table->foreign('storloc_code')->references('storage_location_code')->on('sap_m_storage_locations');
        //     $table->string('storage_type_code')->index()->nullable();
        //     $table->foreign('storage_type_code')->references('storage_type_code')->on('sap_m_storage_types');
        //     $table->string('bin_code')->index()->nullable();
        //     $table->foreign('bin_code')->references('storage_bin_code')->on('sap_m_storage_bins');    
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('m_storage_levels');
    }
}
