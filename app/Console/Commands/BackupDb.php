<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BackupDb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:backup 
                            {dbName=productCopy : create db Name} 
                            {--F|force : delete db if same name db exists}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'backup db to dropbox';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //put login file
        $dbUser= config("database.connections.mysql.username");
        $dbPassword= config("database.connections.mysql.password");
        $dbHost= config("database.connections.mysql.host");
        $content = "[client]
user = $dbUser
password = $dbPassword
host = $dbHost";
        $configFilePath = '/tmp/.tmp.cnf';
        file_put_contents($configFilePath, $content);

        //create dump file
        $env = config('app.env');//env string
        $date = date('Ymd_His');
        $outputFileName = "dump.$env.$date.sql";
        $outputFilePath = "/tmp/$outputFileName";
        $outputCommand = " > $outputFilePath";
        $dumpCommand = "/usr/bin/mysqldump --defaults-extra-file=$configFilePath --all-databases --triggers --routines --events $outputCommand";
        dump($dumpCommand);
        $return = exec($dumpCommand, $arr, $arr2);
        dump($return);
        dump($arr);
        dump($arr2);

        //delete login file
        unlink($configFilePath);

        //upload to dropbox
        $dropboxToken = config("command.backup.dropbox.token");
        $backupPath = config("command.backup.dropbox.path") . $outputFileName;
        $uploadCommand = 'curl -X POST https://content.dropboxapi.com/2/files/upload \
    --header "Authorization: Bearer ' . $dropboxToken .'" \
    --header "Dropbox-API-Arg: {\"path\": \"'.$backupPath. '\",\"mode\": \"add\",\"autorename\": true,\"mute\": false,\"strict_conflict\": false}" \
    --header "Content-Type: application/octet-stream" \
    --data-binary @' . $outputFilePath;
        dump($uploadCommand);
        $return = exec($uploadCommand, $arr, $arr2);
        dump($return);
        dump($arr);
        dump($arr2);
    }
}
