<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RestoreDb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:restore
                            {--R|resorce=dropbox : restore file type}
                            {fileName : restore file name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Restore db';

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
        //get a restore file
        $fileName = $this->argument('fileName');
        $dropboxToken = env("PRODUCT_BACKUP_DROPBOX_TOKEN");
        $downloadPath =  "/tmp/$fileName";
        $backupPath = env("PRODUCT_BACKUP_DROPBOX_PATH") . $fileName;
        $downloadCommand = 'curl -o ' . $downloadPath . ' -X POST https://content.dropboxapi.com/2/files/download \
    --header "Authorization: Bearer ' . $dropboxToken . '" \
    --header "Dropbox-API-Arg: {\"path\": \"' . $backupPath . '\"}"';

        $return = exec($downloadCommand, $arr, $arr2);
        dump($downloadCommand);
        dump($return);
        dump($arr);
        dump($arr2);
        
        //apply the restore file
        $dockerDir = "./../laradock";
        chdir ( $dockerDir );
        $dbContainer = env('DB_CONTAINER');
        $dbUser = env('DB_USERNAME');
        $dbPassword = env('DB_PASSWORD');
        $dbName = env("DB_DATABASE");

        $restoreCommand = "cat $downloadPath | /usr/bin/mysql -h $dbContainer -u $dbUser -p$dbPassword $dbName";
        dump($restoreCommand);
        $return = exec($restoreCommand, $arr, $arr2);
        dump($return);
        dump($arr);
        dump($arr2);
    }
}
