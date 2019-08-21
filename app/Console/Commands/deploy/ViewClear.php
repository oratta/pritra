<?php

namespace App\Console\Commands\deploy;

use App\Console\Helper\DeployHelper as DeployHelper;
use Illuminate\Console\Command;

class ViewClear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deploy:view-clear {stage}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'exec "php artisan view:clear" in a remote environment';

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
        $stage = $this->argument('stage');

        $deployHelper = new DeployHelper;
        $deployHelper->setStage($stage);

        $mainScript = "php artisan view:clear";
        $execScript = $deployHelper->getExecScript($mainScript);

        dump('exec:' . $execScript);
        $return = exec($execScript, $arr, $arr2);
        dump($return);
        dump($arr);
        dump($arr2);
    }
}
