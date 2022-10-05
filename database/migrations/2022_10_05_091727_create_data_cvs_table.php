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
		Schema::create('data_cvs', function(Blueprint $table)
		{
			$table->bigIncrements('data_cv_id');
			$table->string('cv_id')->index('index_cv_id');
			$table->string('private_key')->index('index_private_key');
			$table->bigInteger('user_id')->nullable()->index('index_user_id');
			$table->unsignedInteger('template_cv_id')->nullable()->index('data_cvs_template_cv_id_foreign');
			$table->mediumText('data');
			$table->string('location')->nullable();
			$table->integer('job_cat_id')->default(1);
			$table->bigInteger('company_id')->nullable();
			$table->string('ref_hash')->nullable();
			$table->integer('flag')->default(0);
			$table->integer('view')->default(1);
			$table->timestamp('created_at')->default('0000-00-00 00:00:00')->index('index_created_at');
			$table->timestamp('updated_at')->default('0000-00-00 00:00:00')->index('index_updated_at');
			$table->softDeletes();
			$table->boolean('rated')->nullable()->default(0);
			$table->string('color_scheme')->nullable();
			$table->string('fontsize')->nullable()->default('normal');
			$table->string('spacing')->nullable()->default('normal');
			$table->string('cvtoken')->nullable()->index('index_cvtoken');
			$table->tinyInteger('review_status')->nullable()->default(0);
			$table->string('lang');
			$table->integer('public_view')->default(0)->index('index_public_view');
			$table->integer('private_view')->default(0)->index('index_private_view');
			$table->text('tags');
			$table->tinyInteger('primary')->default(0);
			$table->string('font');
			$table->integer('month_of_exp')->default(0);
			$table->integer('graduate_year')->default(0);
			$table->dateTime('uptop_at')->nullable()->index('index_uptop_at');
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
