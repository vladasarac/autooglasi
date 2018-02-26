<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModelisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modelis', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('marka_id')->unsigned();
            $table->foreign('marka_id')->references('id')->on('markas')->onDelete('cascade');
            $table->string('ime');
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
        Schema::drop('modelis');
    }
}
