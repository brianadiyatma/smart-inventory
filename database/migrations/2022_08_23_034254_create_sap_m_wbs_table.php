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
        Schema::create('sap_m_wbs', function (Blueprint $table) {
            $table->id();           
            $table->unsignedBigInteger('project_id')->index();
            $table->foreign('project_id')->references('id')->on('sap_m_projects')->onDelete('cascade');
            $table->string('wbs_code')->index();
            $table->string('wbs_desc');
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
        Schema::dropIfExists('sap_m_wbs');
    }
};
