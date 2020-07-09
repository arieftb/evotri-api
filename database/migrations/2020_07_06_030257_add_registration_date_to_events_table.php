<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRegistrationDateToEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            //Add Column Registration Open Date & Registration Close Date
            $table->dateTime('registration_open_date');
            $table->dateTime('registration_close_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            //Drop Colum Registration Open Date & Registration Close Date For Rollback Option
            $table->dropColumn('registration_open_date');
            $table->dropColumn('registration_close_date');
        });
    }
}
