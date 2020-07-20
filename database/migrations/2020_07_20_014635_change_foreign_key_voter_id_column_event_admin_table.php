<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeForeignKeyVoterIdColumnEventAdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_administrators', function (Blueprint $table) {
            //
            $table->dropForeign('event_administrators_voter_id_foreign');
            $table->foreign('voter_id')->references('id')->on('voters')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('event_administrators', function (Blueprint $table) {
            //
            $table->dropForeign('event_administrators_voter_id_foreign');
            $table->foreign('voter_id')->references('id')->on('events')->onDelete('cascade');
        });
    }
}
