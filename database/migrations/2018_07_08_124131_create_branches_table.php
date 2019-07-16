<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('has_booking',["1" ,"0"]);
            $table->enum('booking_status',["0" ,"1","2"]);
            $table->enum("has_delivery" , ["1" , "0"]);
            $table->decimal('delivery_price', 10, 2);
            $table->string("ar_address");
            $table->string("en_address");
            $table->string("longitude");
            $table->string("latitude");
            $table->time('start_working_time');
            $table->time('end_working_time');
            $table->string('director_phone');
            $table->string('director_password');
            $table->string('bank_name');
            $table->string('iban_number');
            $table->enum('published' ,["1" , "0"]);
            $table->Integer('provider_id')->unsigned();
            $table->Integer('congestion_settings_id')->unsigned();
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
        Schema::dropIfExists('branches');
    }
}
