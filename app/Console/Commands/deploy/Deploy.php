<?php

namespace App\Console\Commands\Deploy;

use Illuminate\Console\Command;

class Deploy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deploy:all {stage} {--composer-install} {--migrate}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'deploy all';

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
        //file copy (master branch and .env)
        $stage = $this->argument('stage');
        $command = "./vendor/bin/dep deploy $stage";
        dump('exec' . $command);
        $return = exec($command, $arr, $arr2);
        dump($return);
        dump($arr);
        dump($arr2);

        //composer install(option)
        $this->call("deploy:composer", ["stage" => $stage]);

        //artisan:storage:link


        //artisan:view:clear

        //artisan:cache:clear

        //artisan:config:cache

        //artisan:optimize

        //migrate (option)

    }
}
