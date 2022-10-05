<?php

use App\Enums\DataCvTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableDataCvAddColumnsForTopCvUploadFeature extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('data_cvs', function (Blueprint $table) {
            $table->tinyInteger('type')->nullable()->default(DataCvTypeEnum::CV_ONLINE);
            $table->bigInteger('cv_upload_id')->nullable()->index('index_cv_upload_id');
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
            $table->dropColumn('type');
            $table->dropColumn('cv_upload_id');
        });
    }
}
