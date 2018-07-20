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
            $table->foreign('creator')->references('id')->on('user')->onDelete('cascade');
            $table->foreign('subid')->references('id')->on('subject')->onDelete('cascade');
        });

        Schema::table('option', function (Blueprint $table) {
            $table->foreign('queid')->references('id')->on('queans')->onDelete('cascade');
        });

        Schema::table('queans', function (Blueprint $table) {
            $table->foreign('eventid')->references('id')->on('event')->onDelete('cascade');
        });

        Schema::table('req', function (Blueprint $table) {
            $table->foreign('userid')->references('id')->on('user')->onDelete('cascade');
            $table->foreign('eventid')->references('id')->on('event')->onDelete('cascade');
        });

        Schema::table('response', function (Blueprint $table) {
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
            $table->dropForeign('event_creator_foreign');
            $table->dropForeign('event_subid_foreign');
            $table->dropIndex('event_creator_foreign');
            $table->dropIndex('event_subid_foreign');
        });

        Schema::table('option', function (Blueprint $table) {
            $table->dropForeign('option_queid_foreign');
            $table->dropIndex('option_queid_foreign');
        });

        Schema::table('queans', function (Blueprint $table) {
            $table->dropForeign('queans_eventid_foreign');
            $table->dropIndex('queans_eventid_foreign');
        });

        Schema::table('req', function (Blueprint $table) {
            $table->dropForeign('req_userid_foreign');
            $table->dropForeign('req_eventid_foreign');
            $table->dropIndex('req_userid_foreign');
            $table->dropIndex('req_eventid_foreign');
        });

        Schema::table('response', function (Blueprint $table) {
            $table->dropForeign('response_userid_foreign');
            $table->dropForeign('response_queid_foreign');
            $table->dropIndex('response_userid_foreign');
            $table->dropIndex('response_queid_foreign');
        });
        
    }
}
