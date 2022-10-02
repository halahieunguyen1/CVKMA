<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\UserEnum;
return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid();
            $table->string('first_name');//pii
            $table->string('last_name');//pii
            $table->string('address');//pii
            $table->dateTime('dob');//pii
            $table->string('email')->unique()->index();//pii
            $table->string('phone')->unique()->index();//pii
            $table->boolean('gender')->default(UserEnum::MAN);
            $table->string('avatar')->nullable();
            $table->tinyInteger('type')->default(UserEnum::TYPE_NORMAL);
            $table->date('premium_end_at')->nullable();
            $table->dateTime('email_verified_at')->nullable();
            $table->tinyInteger('status')->default(UserEnum::STATUS_OK);

            // Note
            $table->text('admin_note')->nullable();
            $table->integer('admin_note_id')->nullable();
            $table->dateTime('admin_note_at')->nullable();
            // Ban
            $table->integer('ban_admin_id')->nullable();
            $table->text('ban_note')->nullable();
            $table->dateTime('banned_at')->nullable();

            //Goi y viec lam
            $table->boolean('status_find_job')->default(UserEnum::FIND_JOB_ON);
            $table->tinyInteger('job_type')->nullable();// hinh thuc lam viec
            $table->tinyInteger('profession')->nullable();//nghanh nghe
            $table->tinyInteger('exp')->nullable();
            $table->tinyInteger('level')->nullable();
            $table->tinyInteger('salary')->nullable();
            $table->tinyInteger('english_level')->nullable();
            $table->text('desire')->nullable();
            $table->text('introduce')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
