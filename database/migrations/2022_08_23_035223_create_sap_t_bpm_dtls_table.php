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
        Schema::create('sap_t_bpm_dtls', function (Blueprint $table) {            
            $table->id();                
            $table->unsignedBigInteger('bpm_id')->index();
            $table->foreign('bpm_id')->references('id')->on('sap_t_bpms');
            $table->string('reservation_number');
            $table->string('item');
            $table->string('wbs_code')->index()->nullable();
            $table->foreign('wbs_code')->references('wbs_code')->on('sap_m_wbs');
            $table->string('material_code')->index()->nullable();
            $table->foreign('material_code')->references('material_code')->on('sap_m_materials');            
            $table->string('plant_code')->index()->nullable();
            $table->foreign('plant_code')->references('plant_code')->on('sap_m_plants');        
            $table->datetime('requirement_date');
            $table->string('requirement_qty');
            $table->string('uom_code')->index()->nullable()->references('uom_code')->on('sap_m_uoms');
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
        Schema::dropIfExists('sap_t_bpm_dtls');
    }
};
