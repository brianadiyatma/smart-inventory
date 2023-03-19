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
        Schema::create('sap_m_materials', function (Blueprint $table) {
            $table->id();
            $table->string('material_code')->index();
            $table->string('material_desc');
            $table->string('specification');            
            $table->unsignedBigInteger('uom_id')->index();
            $table->foreign('uom_id')->references('id')->on('sap_m_uoms')->onDelete('cascade');
            $table->unsignedBigInteger('material_group_id')->index();
            $table->foreign('material_group_id')->references('id')->on('sap_m_material_groups')->onDelete('cascade');
            $table->unsignedBigInteger('material_type_id')->index();
            $table->foreign('material_type_id')->references('id')->on('sap_m_material_types')->onDelete('cascade');
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
        Schema::dropIfExists('sap_m_materials');
    }
};
