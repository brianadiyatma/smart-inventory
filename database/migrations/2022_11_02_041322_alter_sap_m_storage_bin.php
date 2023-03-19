<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterSapMStorageBin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sap_m_storage_bins', function (Blueprint $table) {
            // $table->unsignedBigInteger('plant_code')->index()->nullable()->after('id');
            // $table->unsignedBigInteger('storage_loc_code')->index()->nullable()->after('plant_code');
            // $table->unsignedBigInteger('storage_type_code')->index()->nullable()->after('storage_loc_code');

            $table->string('plant_code')->nullable()->after('id');
            $table->string('storage_loc_code')->nullable()->after('plant_code');
            $table->string('storage_type_code')->nullable()->after('storage_loc_code');
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
