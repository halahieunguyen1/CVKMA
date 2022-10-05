<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableDataCvsAddColumnIsOnJob extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('data_cvs', function (Blueprint $table) {
            $table->tinyInteger('is_on_job')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('data_cvs', function (Blueprint $table) {
            $table->dropColumn('is_on_job');
        });
    }
}
