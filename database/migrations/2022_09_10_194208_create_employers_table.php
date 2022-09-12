<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use App\Enums\EmployerEnum;
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
        Schema::create('employers', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');//pii
            $table->string('last_name');//pii
            $table->string('address');//pii
            $table->string('dob');//pii
            $table->string('email')->unique()->index();//pii
            $table->string('phone')->unique()->index();//pii
            $table->string('password');
            $table->boolean('gender');
            $table->string('avatar')->nullable();
            $table->dateTime('email_verified_at')->nullable();
            $table->tinyInteger('status')->default(EmployerEnum::STATUS_OK);
            $table->tinyInteger('type')->default(EmployerEnum::TYPE_NORMAL);

            //foreign key
            $table->int('company_id');//pii

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
        Schema::dropIfExists('employers');
    }
};
