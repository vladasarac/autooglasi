<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOglasisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oglasis', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('naslov');
            $table->string('marka');
            $table->string('model');
            $table->integer('cena');
            $table->integer('godiste');
            $table->string('karoserija');
            $table->integer('kubikaza');
            $table->integer('snagaks');
            $table->integer('snagakw');
            $table->integer('kilometraza');
            $table->string('gorivo');
            $table->string('emisionaklasa');
            $table->string('pogon');
            $table->string('menjac');
            $table->integer('ostecen');
            $table->integer('brvrata');
            $table->integer('brsedista');
            $table->string('strvolana');
            $table->string('klima');
            $table->string('boja');
            $table->string('poreklo');
            $table->string('sigurnost')->nullable();
            $table->string('oprema', 450)->nullable();
            $table->string('stanje')->nullable();
            $table->text('tekst')->nullable();
            $table->string('folderslike')->nullable();
            $table->integer('slike');
            $table->integer('brpregleda');
            $table->integer('odobren')->default(0);
            $table->timestamps();
            $table->index(['marka', 'model', 'kubikaza']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('oglasis');
    }
}
