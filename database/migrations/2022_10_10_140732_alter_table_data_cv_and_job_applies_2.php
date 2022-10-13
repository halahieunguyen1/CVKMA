<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('data_cvs', function (Blueprint $table) {
            $table->dropColumn('user_uuid');
        });
        Schema::table('job_cv_applies', function (Blueprint $table) {
            $table->dropColumn('user_uuid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('data_cvs', function (Blueprint $table) {
        //     $table->dropColumn('user_uuid');
        // });
        // Schema::table('job_cv_applies', function (Blueprint $table) {
        //     $table->dropColumn('user_uuid');
        // });
    }
};
