<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('type');
            $table->string('author')->nullable();
            $table->string('publisher')->nullable();
            $table->integer('publicationYear')->nullable();
            $table->string('language')->nullable();
            $table->string('ISBN')->nullable();
            $table->string('description')->nullable();
            $table->integer('pageNumber')->nullable();
            $table->string('status');
            $table->string('image')->nullable();
            $table->string('tag_id')->nullable();
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
        Schema::dropIfExists('books');
    }
}
