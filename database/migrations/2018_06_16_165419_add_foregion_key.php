<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForegionKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event', function (Blueprint $table) {
            $table->index('creator');
            $table->index('subid');
            $table->foreign('creator')->references('id')->on('user')->onDelete('cascade');
            $table->foreign('subid')->references('id')->on('subject')->onDelete('cascade');
        });

        Schema::table('option', function (Blueprint $table) {
            $table->index('queid');
            $table->foreign('queid')->references('id')->on('queans')->onDelete('cascade');
        });

        Schema::table('queans', function (Blueprint $table) {
            $table->index('eventid');
            $table->foreign('eventid')->references('id')->on('event')->onDelete('cascade');
        });

        Schema::table('req', function (Blueprint $table) {
            $table->index('userid');
            $table->index('eventid');
            $table->foreign('userid')->references('id')->on('user')->onDelete('cascade');
            $table->foreign('eventid')->references('id')->on('event')->onDelete('cascade');
        });

        Schema::table('response', function (Blueprint $table) {
            $table->index('userid');
            $table->index('queid');
            $table->foreign('userid')->references('id')->on('user')->onDelete('cascade');
            $table->foreign('queid')->references('id')->on('queans')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('event', function (Blueprint $table) {
            $table->dropForeign('creator');
            $table->dropForeign('subid');
            $table->dropIndex('creator');
            $table->dropIndex('subid');
        });

        Schema::table('option', function (Blueprint $table) {
            $table->dropForeign('queid');
            $table->dropIndex('queid');
        });

        Schema::table('queans', function (Blueprint $table) {
            $table->dropForeign('eventid');
            $table->dropIndex('eventid');
        });

        Schema::table('request', function (Blueprint $table) {
            $table->dropForeign('userid');
            $table->dropForeign('eventid');
            $table->dropIndex('userid');
            $table->dropIndex('eventid');
        });

        Schema::table('response', function (Blueprint $table) {
            $table->dropForeign('userid');
            $table->dropForeign('queid');
            $table->dropIndex('userid');
            $table->dropIndex('queid');
        });
        
    }
}
