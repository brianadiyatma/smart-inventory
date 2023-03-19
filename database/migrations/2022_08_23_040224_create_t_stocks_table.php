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
        Schema::create('t_stocks', function (Blueprint $table) {            
            $table->id();
            $table->string('material_code')->index()->nullable();
            $table->foreign('material_code')->references('material_code')->on('sap_m_materials')->onDelete('cascade');
            $table->string('plant_code')->index()->nullable();
            $table->foreign('plant_code')->references('plant_code')->on('sap_m_plants')->onDelete('cascade');
            $table->string('storloc_code')->index()->nullable();
            $table->foreign('storloc_code')->references('storage_location_code')->on('sap_m_storage_locations')->onDelete('cascade');
            $table->string('bin_code')->index()->nullable();               
            $table->foreign('bin_code')->references('storage_bin_code')->on('sap_m_storage_bins')->onDelete('cascade');               
            $table->string('storage_type_code')->index()->nullable();               
            $table->foreign('storage_type_code')->references('storage_type_code')->on('sap_m_storage_types')->onDelete('cascade');               
            $table->string('special_stock');
            $table->string('special_stock_number')->index()->nullable();
            $table->foreign('special_stock_number')->references('project_code')->on('sap_m_projects')->onDelete('cascade');
            $table->datetime('gr_date');
            $table->string('qty');            
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
        Schema::dropIfExists('t_stocks');
    }
};
