<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ReaderA_ip');
            $table->string('ReaderB_ip');
            $table->string('ReaderC_ip');
            $table->string('ReaderD_ip');
            $table->float('distance_A');
            $table->float('distance_B');
            // $table->float('distance_C');
            // $table->float('distance_D');
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
        Schema::dropIfExists('settings');
    }
}
