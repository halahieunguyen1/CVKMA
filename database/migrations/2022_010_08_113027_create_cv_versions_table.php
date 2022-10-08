<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateCvVersionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cv_versions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('data_cv_id')->default(0);
            $table->unsignedInteger('template_cv_id')->nullable()->index();
            $table->char('hash_all', 16)->charset('binary')->nullable();
            $table->integer('data_cv_version_id')->default(0)->index();
            $table->string('color_scheme')->nullable();
            $table->string('fontsize')->nullable()->default('normal');
			$table->string('spacing')->nullable()->default('normal');
            $table->string('font')->nullable();
            $table->string('lang')->nullable();
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
        Schema::dropIfExists('cv_versions');
    }
}
