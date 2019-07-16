<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_code');
            $table->dateTime('order_date');
            $table->enum("is_delivery",["1" , "0"]);
            $table->decimal('delivery_price', 10, 2);
            $table->decimal('total_price', 10, 2);
            $table->decimal('app_percentage', 10, 2);
            $table->string("user_longitude");
            $table->string("user_latitude");
            $table->Integer("order_status_id")->unsigned();
            $table->Integer("payment_id")->unsigned();
            $table->Integer("branch_id")->unsigned();
            $table->Integer("user_id")->unsigned();
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
        Schema::dropIfExists('orders');
    }
}
