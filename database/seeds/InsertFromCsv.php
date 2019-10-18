<?php
namespace Database\Seeds;
use Illuminate\Support\Facades\DB;
trait InsertFromCsv{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function insertFromCsv()
    {
        if(!$this->csvFileName){
            throw new Exception('not set csv file name. set \$this->csvFileName');
        }
        if(!$this->tableName){
            throw new Exception('not set csv table name. set \$this->tableName');
        }
        if(!isset($this->csvFilePath) || !$this->csvFilePath) {
            $this->csvFilePath = $this->getCsvFilePath($this->csvFileName);
        }
        $insertInstanceArray = $this->getArrayFromCsv();
        DB::table($this->tableName)->insert($insertInstanceArray);

    }

    protected function getCsvFilePath($filename)
    {
        return database_path() . "/seeds/${filename}";
    }

    protected function getArrayFromCsv()
    {
        if(!$this->csvFilePath) {
            throw new Exception("not set csv File path. set csv path to \$this->csvFilePath or put csv file in database/seeds dir");
        }
        $content = file_get_contents($this->csvFilePath);
        $content = str_replace(['\r\n','\r','\n'], '\n', $content);
        $contentArray = explode("\n", $content);
        $indexArray = array_shift($contentArray);
        $indexArray = explode(',', $indexArray);
        foreach($indexArray as $key => $index) $indexArray[$key] = trim($index);
        $returnArray = [];
        foreach ($contentArray as $index => $recode) {
            $recodeArray = explode(',', $recode);
            $instanceArray = [];
            foreach($recodeArray as $columnNumber => $value){
                $instanceArray[$indexArray[$columnNumber]] = trim($value);
            }
            $returnArray[$instanceArray['id']] = $instanceArray;
        }

        return $returnArray;
    }
}