<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RefactorStepMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('step_masters', function (Blueprint $table) {
            $table->unsignedSmallInteger('level1_rep_count')->nullable();
        });
        Schema::table('step_masters', function (Blueprint $table) {
            $table->unsignedTinyInteger('level1_set_count')->nullable();
        });
        Schema::table('step_masters', function (Blueprint $table) {
            $table->unsignedTinyInteger('level2_rep_count')->nullable();
        });
        Schema::table('step_masters', function (Blueprint $table) {
            $table->unsignedTinyInteger('level2_set_count')->nullable();
        });
        Schema::table('step_masters', function (Blueprint $table) {
            $table->unsignedTinyInteger('level3_rep_count')->nullable();
        });
        Schema::table('step_masters', function (Blueprint $table) {
            $table->unsignedTinyInteger('level3_set_count')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('step_masters', function (Blueprint $table) {
            $table->dropColumn('level1_rep_count');
        });
        Schema::table('step_masters', function (Blueprint $table) {
            $table->dropColumn('level1_set_count');
        });
        Schema::table('step_masters', function (Blueprint $table) {
            $table->dropColumn('level2_rep_count');
        });
        Schema::table('step_masters', function (Blueprint $table) {
            $table->dropColumn('level2_set_count');
        });
        Schema::table('step_masters', function (Blueprint $table) {
            $table->dropColumn('level3_rep_count');
        });
        Schema::table('step_masters', function (Blueprint $table) {
            $table->dropColumn('level3_set_count');
        });


    }
}
