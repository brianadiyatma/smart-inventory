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
        Schema::create('sap_t_gi_dtls', function (Blueprint $table) {            
            $table->id();            
            $table->unsignedBigInteger('gi_id')->index();
            $table->foreign('gi_id')->references('id')->on('sap_t_gis')->onDelete('cascade');
            $table->string('material_code')->index()->nullable();
            $table->foreign('material_code')->references('material_code')->on('sap_m_materials');
            $table->string('material_desc');
            $table->string('qty_order');
            $table->string('qty_serve');
            $table->string('storloc_code')->index()->nullable();
            $table->foreign('storloc_code')->references('storage_location_code')->on('sap_m_storage_locations');        
            $table->string('note');
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
        Schema::dropIfExists('sap_t_gi_dtls');
    }
};
