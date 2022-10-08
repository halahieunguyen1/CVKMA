<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataCvVersionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_cv_versions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('data_cv_id')->nullable();
            $table->char('hash', 16)->charset('binary');
            $table->mediumText('data');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_cv_versions');
    }
}
