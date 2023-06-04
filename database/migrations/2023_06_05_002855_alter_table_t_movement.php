<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableTMovement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('t_movements', function (Blueprint $table) {            
            $table->string('mover')->nullable()->after('bin_destination_code');            
        });
        Schema::table('t_movements', function (Blueprint $table) {            
            $table->string('description')->nullable()->after('mover');            
        });
        Schema::table('t_movements', function (Blueprint $table) {            
            $table->string('file')->nullable()->after('description');            
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
