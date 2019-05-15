<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkoutSetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workout_sets', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("user_id");
            $table->unsignedTinyInteger("menu_master_id");
            $table->string("workout_ids");
            $table->dateTime("start_time");
            $table->dateTime("end_time");
            $table->unsignedSmallInteger("min_step_master_id");
            $table->unsignedSmallInteger("min_rep_count");
            $table->unsignedTinyInteger("set_count");
            $table->unsignedTinyInteger("level");
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
        Schema::dropIfExists('workout_sets');
    }
}
