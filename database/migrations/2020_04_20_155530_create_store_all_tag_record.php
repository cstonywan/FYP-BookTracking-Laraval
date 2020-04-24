<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreAllTagRecord extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_all_tag_record', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tag_id');
            $table->string('tag_rssi')->nullable();
            $table->integer('tag_count')->nullable();
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
        Schema::dropIfExists('store_all_tag_record');
    }
}
