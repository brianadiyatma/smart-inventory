<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterStartedAtBpmSttpDtl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sap_t_bpm_dtls', function (Blueprint $table) {            
            $table->dateTime('started_at')->nullable()->after('updated_at');            
        });
        Schema::table('sap_t_sttp_dtls', function (Blueprint $table) {            
            $table->dateTime('started_at')->nullable()->after('updated_at');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sap_t_bpm_dtls', function (Blueprint $table) {            
            $table->dateTime('started_at')->nullable()->after('updated_at');            
        });
        Schema::table('sap_t_sttp_dtls', function (Blueprint $table) {            
            $table->dateTime('started_at')->nullable()->after('updated_at');            
        });
    }
}
