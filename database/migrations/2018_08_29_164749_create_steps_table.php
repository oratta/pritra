<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('steps', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedTinyInteger('menu_master_id');
            $table->unsignedInteger('step_number');
            $table->string('name');
            $table->text('description');
            $table->unsignedInteger('rep1_start_count');
            $table->unsignedInteger('rep2_start_count');
            $table->unsignedInteger('rep3_start_count');
            $table->unsignedInteger('rep3_master_count');
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
        Schema::dropIfExists('steps');
    }
}
