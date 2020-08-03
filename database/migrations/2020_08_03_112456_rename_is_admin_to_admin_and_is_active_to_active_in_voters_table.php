<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameIsAdminToAdminAndIsActiveToActiveInVotersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('voters', function (Blueprint $table) {
            //
            $table->renameColumn('is_admin', 'admin');
            $table->renameColumn('is_active', 'active');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('voters', function (Blueprint $table) {
            //
            $table->renameColumn('admin', 'is_admin');
            $table->renameColumn('active', 'is_active');
        });
    }
}
