<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRfidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rfids', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tag_id')->nullable();
            $table->string('tag_pc_value')->nullable();
            $table->integer('tag_count')->nullable();
            $table->string('tag_rssi')->nullable();
            $table->string('reader_antenna')->nullable();
            $table->string('reader_record_time')->nullable();
            $table->string('reader_ip')->nullable();                                
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
        Schema::dropIfExists('rfids');
    }
}
