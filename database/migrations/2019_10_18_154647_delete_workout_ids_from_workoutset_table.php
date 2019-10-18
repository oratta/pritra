<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteWorkoutIdsFromWorkoutsetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('workout_sets', function (Blueprint $table) {
            $table->dropColumn('workout_ids');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('workout_sets', function (Blueprint $table) {
            $table->string("workout_ids")->nullable();
        });
    }
}
