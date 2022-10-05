<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableDataCvsAddCvVersionIdColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('data_cvs', function (Blueprint $table) {
            $table->char('hash', 16)->charset('binary')->after('data_cv_id')->nullable()->index();
            $table->bigInteger('cv_version_id')->after('hash')->default(0)->index();
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
            $table->dropColumn('hash');
            $table->dropColumn('cv_version_id');
        });
    }
}
