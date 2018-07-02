<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQueansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('queans', function (Blueprint $table) {
            $table->increments('id');
            $table->text('que');
            $table->string('img', 50)->nullable();
            $table->integer('eventid')->unsigned();
            $table->boolean('quetype');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('queans');
    }
}
