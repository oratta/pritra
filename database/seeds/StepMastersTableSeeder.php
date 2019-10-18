<?php

use Illuminate\Database\Seeder;

class StepMastersTableSeeder extends Seeder
{
    use Database\Seeds\InsertFromCsv;

    protected $csvFileName = 'StepMasterTable.csv';
    protected $tableName = 'step_masters';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->insertFromCsv();
    }
}
