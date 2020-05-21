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
            $table->unsignedSmallInteger('planed_min_rep_count')->default(0);
        });
        Schema::table('workout_sets', function (Blueprint $table) {
            $table->unsignedTinyInteger("planed_set_count")->default(0);
        });
        Schema::table('workout_sets', function (Blueprint $table) {
            $table->unsignedTinyInteger("planed_level")->default(0);
        });
        Schema::table('workout_sets', function (Blueprint $table) {
            $table->unsignedTinyInteger("is_plan")->default(0);
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
        });
        Schema::table('workout_sets', function (Blueprint $table) {
            $table->dropColumn("planed_set_count");
        });
        Schema::table('workout_sets', function (Blueprint $table) {
            $table->dropColumn("planed_level");
        });
        Schema::table('workout_sets', function (Blueprint $table) {
            $table->dropColumn("is_plan");
        });
    }
}
