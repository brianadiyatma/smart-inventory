<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterBpm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sap_t_bpm_dtls', function (Blueprint $table) {            
            $table->string('storage_location_code')->nullable()->after('plant_code');            
        });

        Schema::table('sap_t_bpms', function (Blueprint $table) {            
            $table->string('storage_location_code')->nullable()->after('fiscal_year');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
