<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CopyProductDb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:copyProduct 
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
        $sshCommand = "ssh $productHost -l oratta $productServerCommand";
        $return = exec($sshCommand, $arr, $arr2);
        dump($sshCommand);
        dump($return);
        dump($arr);
        dump($arr2);
        //drop db if force option
        //if same name db exist
        //if it can be contain a drop db command in a dump file, this operation is not necessary

        //create db
        //if it can be contain a create db command in a dump file, this operation is not necessary

        //exec dump file

        //delete dump file
    }
}
