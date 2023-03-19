<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterSoftDeletes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sap_m_projects', function (Blueprint $table) {
            $table->softDeletes();          
        });

        Schema::table('sap_m_materials', function (Blueprint $table) {
            $table->softDeletes();          
        });

        Schema::table('sap_m_material_groups', function (Blueprint $table) {
            $table->softDeletes();          
        });
        
        Schema::table('sap_m_material_types', function (Blueprint $table) {
            $table->softDeletes();          
        });
        
        Schema::table('sap_m_plants', function (Blueprint $table) {
            $table->softDeletes();          
        });
        
        Schema::table('sap_m_storage_bins', function (Blueprint $table) {
            $table->softDeletes();          
        });
        
        Schema::table('sap_m_storage_locations', function (Blueprint $table) {
            $table->softDeletes();          
        });
        
        Schema::table('sap_m_storage_types', function (Blueprint $table) {
            $table->softDeletes();          
        });
        
        Schema::table('sap_m_uoms', function (Blueprint $table) {
            $table->softDeletes();          
        });
        
        Schema::table('sap_m_wbs', function (Blueprint $table) {
            $table->softDeletes();          
        });

        Schema::table('sap_t_bpms', function (Blueprint $table) {            
            $table->softDeletes();
        });

        Schema::table('sap_t_bpm_dtls', function (Blueprint $table) {            
            $table->softDeletes();          
        });

        Schema::table('sap_t_gis', function (Blueprint $table) {
            $table->softDeletes();          
        });
        
        Schema::table('sap_t_gi_dtls', function (Blueprint $table) {
            $table->softDeletes();          
        });
        
        Schema::table('sap_t_sttps', function (Blueprint $table) {
            $table->softDeletes();          
        });
        
        Schema::table('sap_t_sttp_dtls', function (Blueprint $table) {
            $table->softDeletes();          
        });

        Schema::table('t_inbounds', function (Blueprint $table) {
            $table->softDeletes();          
        });

        Schema::table('t_outbounds', function (Blueprint $table) {
            $table->softDeletes();          
        });

        Schema::table('t_stocks', function (Blueprint $table) {
            $table->softDeletes();          
        });

        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes();          
        });

        Schema::table('m_divisions', function (Blueprint $table) {
            $table->softDeletes();          
        });

        Schema::table('m_positions', function (Blueprint $table) {
            $table->softDeletes();          
        });

        Schema::table('user_notifikasi', function (Blueprint $table) {
            $table->softDeletes();          
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sap_m_projects', function (Blueprint $table) {
            $table->dropSoftDeletes();        
        });

        Schema::table('sap_m_materials', function (Blueprint $table) {
            $table->dropSoftDeletes();        
        });

        Schema::table('sap_m_material_groups', function (Blueprint $table) {
            $table->dropSoftDeletes();        
        });
        
        Schema::table('sap_m_material_types', function (Blueprint $table) {
            $table->dropSoftDeletes();        
        });
        
        Schema::table('sap_m_plants', function (Blueprint $table) {
            $table->dropSoftDeletes();        
        });
        
        Schema::table('sap_m_storage_bins', function (Blueprint $table) {
            $table->dropSoftDeletes();        
        });
        
        Schema::table('sap_m_storage_locations', function (Blueprint $table) {
            $table->dropSoftDeletes();        
        });
        
        Schema::table('sap_m_storage_types', function (Blueprint $table) {
            $table->dropSoftDeletes();        
        });
        
        Schema::table('sap_m_uoms', function (Blueprint $table) {
            $table->dropSoftDeletes();        
        });
        
        Schema::table('sap_m_wbs', function (Blueprint $table) {
            $table->dropSoftDeletes();        
        });

        Schema::table('sap_t_bpms', function (Blueprint $table) {            
            $table->softDeletes();
        });

        Schema::table('sap_t_bpm_dtls', function (Blueprint $table) {            
            $table->dropSoftDeletes();        
        });

        Schema::table('sap_t_gis', function (Blueprint $table) {
            $table->dropSoftDeletes();        
        });
        
        Schema::table('sap_t_gi_dtls', function (Blueprint $table) {
            $table->dropSoftDeletes();        
        });
        
        Schema::table('sap_t_sttps', function (Blueprint $table) {
            $table->dropSoftDeletes();        
        });
        
        Schema::table('sap_t_sttp_dtls', function (Blueprint $table) {
            $table->dropSoftDeletes();        
        });

        Schema::table('t_inbounds', function (Blueprint $table) {
            $table->dropSoftDeletes();        
        });

        Schema::table('t_outbounds', function (Blueprint $table) {
            $table->dropSoftDeletes();        
        });

        Schema::table('t_stocks', function (Blueprint $table) {
            $table->dropSoftDeletes();        
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropSoftDeletes();        
        });

        Schema::table('m_divisions', function (Blueprint $table) {
            $table->softDeletes();          
        });

        Schema::table('m_positions', function (Blueprint $table) {
            $table->softDeletes();          
        });

        Schema::table('user_notifikasi', function (Blueprint $table) {
            $table->softDeletes();          
        });
    }
}
