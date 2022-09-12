<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\JobEnum;
return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('employer_id');
            $table->integer('company_id');
            $table->integer('salary_from');
            $table->integer('salary_to');
            $table->tinyInteger('salary_type')->default(JobEnum::SALARY_TYPE_VND);
            $table->dateTime('publish_from');
            $table->dateTime('publish_to');
            $table->dateTime('deadline');
            $table->boolean('is_publish')->default(JobEnum::PUBLISH_ON);
            $table->text('description');
            $table->text('job_requirement');
            $table->text('job_benefit');
            $table->integer('view');
            $table->tinyInteger('quantity');
            $table->tinyInteger('exp_years_from');
            $table->tinyInteger('exp_years_to');
            $table->tinyInteger('position_id');
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
        Schema::dropIfExists('jobs');
    }
};
