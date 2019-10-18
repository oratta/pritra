<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStepMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('step_masters', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedTinyInteger('menu_master_id');
            $table->unsignedInteger('step_number');
            $table->string('name');
            $table->text('description');
            $table->unsignedInteger('rep1_start_count')->default(0);
            $table->unsignedInteger('rep2_start_count')->default(0);
            $table->unsignedInteger('rep3_start_count')->default(0);
            $table->unsignedInteger('rep3_master_count')->default(0);
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
        Schema::dropIfExists('step_masters');
    }
}
