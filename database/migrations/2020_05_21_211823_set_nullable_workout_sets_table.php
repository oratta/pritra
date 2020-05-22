<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetNullableWorkoutSetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('workout_sets', function (Blueprint $table) {
            $table->dateTime('start_time')->nullable()->change();
        });
        Schema::table('workout_sets', function (Blueprint $table) {
            $table->dateTime('end_time')->nullable()->change();
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
            Schema::table('workout_sets', function (Blueprint $table) {
                $table->dateTime('start_time')->nullable(false)->change();
            });
            Schema::table('workout_sets', function (Blueprint $table) {
                $table->dateTime('end_time')->nullable(false)->change();
            });

        });
    }
}
