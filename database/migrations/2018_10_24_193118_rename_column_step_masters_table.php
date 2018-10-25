<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameColumnStepMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('step_masters', function (Blueprint $table) {
            $table->renameColumn('rep1_start_count', 'set1_start_count');
            $table->renameColumn('rep2_start_count', 'set2_start_count');
            $table->renameColumn('rep3_start_count', 'set3_start_count');
            $table->renameColumn('rep3_master_count', 'set3_master_count');
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
            $table->renameColumn('set1_start_count', 'rep1_start_count');
            $table->renameColumn('set2_start_count', 'rep2_start_count');
            $table->renameColumn('set3_start_count', 'rep3_start_count');
            $table->renameColumn('set3_master_count', 'rep3_master_count');
        });
    }
}
