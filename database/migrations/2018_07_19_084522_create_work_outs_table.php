<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkOutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_outs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->references('id')->on('users')->unsigned()->index();
            $table->smallInteger('menu_master_id');
            $table->smallInteger('step_master_id');
            $table->smallInteger('count');
            $table->smallInteger('difficulty_type');
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
        Schema::dropIfExists('work_outs');
    }
}
