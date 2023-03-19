<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TMovement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_movements', function (Blueprint $table) {
            $table->id();
            $table->string('movement_number');
            $table->string('material_code');
            $table->string('plant_code');
            $table->string('storloc_code');
            $table->string('special_stock');
            $table->string('special_stock_number');
            $table->string('qty');
            $table->string('bin_origin_code');
            $table->string('bin_destination_code');
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
        //
    }
}
