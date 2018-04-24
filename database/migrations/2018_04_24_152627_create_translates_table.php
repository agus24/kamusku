<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTranslatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('translate', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('dari')->unsigned();
            $table->integer('tujuan')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('rate');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('dari')->references('id')->on('kata');
            $table->foreign('tujuan')->references('id')->on('kata');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('translate');
    }
}
