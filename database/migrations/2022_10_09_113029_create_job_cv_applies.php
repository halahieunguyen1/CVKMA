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
        Schema::create('job_cv_applies', function (Blueprint $table) {
            $table->id();
            $table->string('fullname');
            $table->string('email');
            $table->string('phone');
            $table->char('hash', 16)->charset('binary')->nullable()->index();
            $table->bigInteger('cv_version_id')->default(0)->index();
            $table->integer('user_id');
            $table->integer('data_cv_id');
            $table->integer('job_id');
            $table->integer('employer_id');
            $table->integer('company_id');
			$table->unsignedInteger('template_cv_id')->nullable()->index();
            $table->text('data');
            $table->tinyInteger('status');
            $table->string('color_scheme')->nullable();
			$table->string('fontsize')->nullable()->default('normal');
			$table->string('spacing')->nullable()->default('normal');
			$table->boolean('viewed');
			$table->string('font');
			$table->text('letter');

            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_cv_applies');
    }
};
