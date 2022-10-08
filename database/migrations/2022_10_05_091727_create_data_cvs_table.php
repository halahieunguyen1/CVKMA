<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataCvsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::dropIfExists('data_cvs');
		Schema::create('data_cvs', function(Blueprint $table)
		{
			$table->bigIncrements('data_cv_id');
			$table->string('cv_id')->index();
			$table->string('private_key')->index();
			$table->bigInteger('user_id')->nullable()->index();
			$table->unsignedInteger('template_cv_id')->nullable()->index();
			$table->mediumText('data');
			$table->timestamps();
			$table->softDeletes();
			$table->string('color_scheme')->nullable();
			$table->string('fontsize')->nullable()->default('normal');
			$table->string('spacing')->nullable()->default('normal');
			$table->string('cvtoken')->nullable()->index();
			$table->string('lang');
			$table->integer('public_view')->default(0)->index();
			$table->integer('private_view')->default(0)->index();
			$table->text('tags');
			$table->tinyInteger('primary')->default(0);
			$table->string('font');
			$table->integer('month_of_exp')->default(0);
			$table->integer('graduate_year')->default(0);
			$table->tinyInteger('platform')->nullable();
			$table->tinyInteger('is_profile')->default(0);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('data_cvs');
	}
}
