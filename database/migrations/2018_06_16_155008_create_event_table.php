<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->text('description');
            $table->integer('subid')->unsigned();
            $table->string('img', 50)->default('img/EventIcon.png');
            $table->dateTime('start');
            $table->dateTime('end');
            $table->integer('creator')->unsigned();
            $table->integer('duration');
            $table->integer('correctmark');
            $table->integer('wrongmark');
            $table->integer('quedisplay');
            $table->boolean('isactive');
            $table->boolean('auto_access')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('event');
    }
}
