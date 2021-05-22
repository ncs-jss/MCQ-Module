<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReqTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('req', function (Blueprint $table) {
            $table->integer('userid')->unsigned();
            $table->integer('eventid')->unsigned();
            $table->boolean('status');
            $table->dateTime('start')->nullable()->default(NULL);
            $table->string('que', 300)->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('req');
    }
}
