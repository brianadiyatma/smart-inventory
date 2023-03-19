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
        Schema::create('sap_t_sttps', function (Blueprint $table) {
            $table->id();
            $table->string('pembuat')->nullable();
            $table->string('doc_number');
            $table->date('doc_date');
            $table->string('po_number')->nullable();            
            $table->string('project_code')->index()->nullable();
            $table->foreign('project_code')->references('project_code')->on('sap_m_projects');
            $table->string('status')->nullable();
            $table->string('fiscal_year');
            $table->datetime('enter_date')->nullable();
            $table->datetime('started_at')->nullable();
            $table->datetime('finished_at')->nullable();
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
        Schema::dropIfExists('sap_t_sttps');
    }
};
