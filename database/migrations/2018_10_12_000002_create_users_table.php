<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email', 100)->unique();
            $table->string('phone', 100)->unique();
            $table->string('password');
            $table->string('age');
            $table->enum('gender', ['male', 'female']);
            $table->rememberToken();
            $table->Integer('image_id')->unsigned()->nullable();
            $table->Integer('country_id')->unsigned();
            $table->Integer('city_id')->unsigned();
            $table->enum('phoneactivated', ['0', '1'])->default('0');
            $table->string("device_reg_id" ,255);
            $table->string("activate_phone_hash")->nullable();
            $table->string("activate_mail_hash")->nullable();
            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
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
}

