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
        $dropboxToken = config("command.backup.dropbox.token");
        $dropboxPath = config('command.backup.dropbox.path');
        $downloadPath =  "/tmp/$fileName";

        $backupPath = $dropboxPath . $fileName;
        $downloadCommand = 'curl -o ' . $downloadPath . ' -X POST https://content.dropboxapi.com/2/files/download \
    --header "Authorization: Bearer ' . $dropboxToken . '" \
    --header "Dropbox-API-Arg: {\"path\": \"' . $backupPath . '\"}"';
        dump($downloadCommand);
        $return = exec($downloadCommand, $arr, $arr2);
        dump($return);
        dump($arr);
        dump($arr2);
        
        //apply the restore file
        $dbHost = config('database.connections.mysql.host');
        $dbUser = config('command.backup.database.admin.username');
        $dbPassword = config('command.backup.database.admin.password');
        $dbName = config('database.connections.mysql.database');

        //reset GTIDs
        $resetCommand = "/usr/bin/mysql -h $dbHost -u $dbUser -p$dbPassword $dbName -e \"RESET MASTER;\"";
        dump($resetCommand);
        $return = exec($resetCommand, $arr, $arr2);
        dump($return);
        dump($arr);
        dump($arr2);

        $restoreCommand = "cat $downloadPath | /usr/bin/mysql -h $dbHost -u $dbUser -p$dbPassword";
        dump($restoreCommand);
        $return = exec($restoreCommand, $arr, $arr2);
        dump($return);
        dump($arr);
        dump($arr2);
    }
}
