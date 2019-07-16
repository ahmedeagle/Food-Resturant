<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('providers', function (Blueprint $table) {
            $table->increments('id');
            $table->string("ar_name");
            $table->string("en_name");
            $table->text("en_description");
            $table->text("ar_description");
            $table->string("email");
            $table->string("phone");
            $table->string("password");
            $table->Integer("country_id")->unsigned();
            $table->Integer("city_id")->unsigned();
            $table->Integer("image_id")->unsigned();
            $table->Integer("category_id")->unsigned();
            $table->string("device_reg_id" ,255);
            $table->enum('phoneactivated', ['0', '1'])->default('0');
            $table->enum('accountactivated', ['0', '1'])->default('0');
            $table->dateTime("activation_date");
            $table->decimal('order_app_percentage', 10, 2);
            $table->enum("has_subscriptions", ["1","0"]);
            $table->enum("subscriptions_period", ["1","2"]);
            $table->float("subscriptions_amount");
            $table->string("longitude");
            $table->string("latitude");
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
        Schema::dropIfExists('providers');
    }
}
