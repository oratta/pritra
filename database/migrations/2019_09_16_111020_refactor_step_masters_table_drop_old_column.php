<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RefactorStepMastersTableDropOldColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('step_masters', function (Blueprint $table) {
            $table->dropColumn('set1_start_count');
            $table->dropColumn('set2_start_count');
            $table->dropColumn('set3_start_count');
            $table->dropColumn('set3_master_count');
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
            $table->unsignedInteger('set1_start_count');
            $table->unsignedInteger('set2_start_count');
            $table->unsignedInteger('set3_start_count');
            $table->unsignedInteger('set3_master_count');
        });
    }
}
