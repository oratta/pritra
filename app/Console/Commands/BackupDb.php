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
    protected $signature = 'db:backupProduct 
                            {dbName=productCopy : create db Name} 
                            {--F|force : delete db if same name db exists}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Copy product db to the develop env';

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
        //create dump file
        $productHost = env('PRODUCT_HOST');
        $productDbContainerUser = env('PRODUCT_DB_CONTAINER_USER');
        $productDbContainer = env('PRODUCT_DB_CONTAINER');
        $productDbName = env("PRODUCT_DB_NAME");
        $productDbUser= env("PRODUCT_DB_USER");
        $productDbPassword = env("PRODUCT_DB_PASSWORD");
        $dumpCommand = "sudo docker-compose exec --user=$productDbContainerUser $productDbContainer /usr/bin/mysqldump -u $productDbUser --password=$productDbPassword $productDbName";
        $productServerCommand = '"cd laradock;' . $dumpCommand . ';"';
        $date = date('Ymd_His');
        $outputFile = "/tmp/dump.$date.sql";
        $outputCommand = " > $outputFile";
        $sshCommand = "ssh $productHost -l oratta $productServerCommand $outputCommand";
        $return = exec($sshCommand, $arr, $arr2);
        dump($sshCommand);
        dump($return);
        dump($arr);
        dump($arr2);

        //upload to dropbox

        $dropboxToken = env("PRODUCT_BACKUP_DROPBOX_TOKEN");
        $backupPath = env("PRODUCT_BACKUP_DROPBOX_PATH") . "dump.$date.sql";
        $uploadCommand = 'curl -X POST https://content.dropboxapi.com/2/files/upload \
    --header "Authorization: Bearer ' . $dropboxToken .'" \
    --header "Dropbox-API-Arg: {\"path\": \"'.$backupPath. '\",\"mode\": \"add\",\"autorename\": true,\"mute\": false,\"strict_conflict\": false}" \
    --header "Content-Type: application/octet-stream" \
    --data-binary @' . $outputFile;

        $returnUpdate = exec($uploadCommand, $arr, $arr2);
        dump($uploadCommand);
        dump($return);
        dump($arr);
        dump($arr2);
    }
}
