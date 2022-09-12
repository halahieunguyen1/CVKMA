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
        Schema::create('table_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->int('employer_id');
            $table->int('company_id');
            $table->int('salary_from');
            $table->int('salary_to');
            $table->tinyInteger('salary_type')->default(JobEnum::SALARY_TYPE_VND);
            $table->dataTime('publish_from');
            $table->dataTime('publish_to');
            $table->dataTime('deadline');
            $table->boolean('is_publish')->default(JobEnum::PUBLISH_ON);
            $table->text('description');
            $table->text('job_requirement');
            $table->text('job_benefit');
            $table->int('view');
            $table->tinyInteger('quantity');
            $table->tinyInteger('exp_years_from');
            $table->tinyInteger('exp_years_to');
            $table->tinyInteger('position_id');
            $table->string('address');
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
        Schema::dropIfExists('table_jobs');
    }
};
