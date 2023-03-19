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
        Schema::create('sap_t_sttp_dtls', function (Blueprint $table) {            
            $table->id();             
            $table->unsignedBigInteger('sttp_id')->index();
            $table->foreign('sttp_id')->references('id')->on('sap_t_sttps')->onDelete('cascade');        
            $table->string('line_item');           
            $table->string('wbs_code')->index()->nullable()->references('wbs_code')->on('sap_m_wbs');
            $table->foreign('wbs_code')->references('wbs_code')->on('sap_m_wbs')->onDelete('cascade');
            $table->string('material_code')->index()->nullable()->references('material_code')->on('sap_m_materials');
            $table->foreign('material_code')->references('material_code')->on('sap_m_materials')->onDelete('cascade');
            $table->string('material_desc');         
            $table->string('uom'); 
            $table->string('qty_po');
            $table->string('qty_gr_105');
            $table->string('qty_ncr');
            $table->string('qty_warehouse');
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
        Schema::dropIfExists('sap_t_sttp_dtls');
    }
};
