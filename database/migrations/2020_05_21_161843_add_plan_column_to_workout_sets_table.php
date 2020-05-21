<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPlanColumnToWorkoutSetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('workout_sets', function (Blueprint $table) {
            $table->unsignedSmallInteger('planed_min_rep_count');
            $table->unsignedTinyInteger("planed_set_count");
            $table->unsignedTinyInteger("planed_level");
            $table->unsignedTinyInteger("is_plan");
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
            $table->dropColumn('planed_min_rep_count');
            $table->dropColumn("planed_set_count");
            $table->dropColumn("planed_level");
            $table->dropColumn("is_plan");
        });
    }
}
