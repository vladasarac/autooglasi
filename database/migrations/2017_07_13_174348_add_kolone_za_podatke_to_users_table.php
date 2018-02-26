<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddKoloneZaPodatkeToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    //dodavanje kolona u 'users' tabelu koje trebaju kad user popuni formu za izmenu i dodavanje podataka u profil.blade.php
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('prikaziemail')->default(0);
            $table->integer('pravnolice')->default(0);
            $table->string('adresa')->nullable();
            $table->string('telefon2', 20)->nullable();
            $table->string('telefon3', 20)->nullable();
            $table->integer('logo')->default(0);
            $table->double('lat')->nullable();
            $table->double('lng')->nullable();
            $table->integer('zoom')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('prikaziemail');
            $table->dropColumn('pravnolice');
            $table->dropColumn('adresa');
            $table->dropColumn('telefon2');
            $table->dropColumn('telefon3');
            $table->dropColumn('logo');
            $table->dropColumn('lat');
            $table->dropColumn('lng');
            $table->dropColumn('zoom');
        });
    }
}
