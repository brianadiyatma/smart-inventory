<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_inbounds', function (Blueprint $table) {            
            $table->id();            
            $table->unsignedBigInteger('sttp_id')->index();
            $table->foreign('sttp_id')->references('id')->on('sap_t_sttps');
            $table->string('line_item');           
            $table->string('material_code')->index()->nullable();
            $table->foreign('material_code')->references('material_code')->on('sap_m_materials');
            $table->string('plant_code')->index()->nullable();
            $table->foreign('plant_code')->references('plant_code')->on('sap_m_plants');
            $table->string('storloc_code')->index()->nullable();
            $table->foreign('storloc_code')->references('storage_location_code')->on('sap_m_storage_locations');
            $table->string('bin_code')->index()->nullable();
            $table->foreign('bin_code')->references('storage_bin_code')->on('sap_m_storage_bins');    
            $table->string('wbs_code')->index()->nullable();
            $table->foreign('wbs_code')->references('wbs_code')->on('sap_m_wbs');
            $table->string('qty_in');
            $table->datetime('posting_date');
            $table->unsignedBigInteger('user_id')->index();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('photo_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_inbounds');
    }
};
