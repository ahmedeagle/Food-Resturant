<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meals', function (Blueprint $table) {
            $table->increments('id');
            $table->string("en_name");
            $table->string("ar_name");
            $table->text("ar_description");
            $table->text("en_description");
            $table->string("calories");
            $table->integer("mealCategory_id")->unsigned();
            $table->integer("branch_id")->unsigned();
            $table->double("price");
            $table->enum("published" , ["1" , "0"]);
            $table->enum("recommend" , ["1" , "0"]);
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
        Schema::dropIfExists('meals');
    }
}
