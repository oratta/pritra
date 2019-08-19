<?php

namespace App\Console\Commands\deploy;

use Illuminate\Console\Command;
use Symfony\Component\Yaml\Yaml as Yaml;
use App\Console\Helper\DeployHelper as DeployHelper;

class ComposerInstall extends Command
{
    const COMPOSER_PATH = "/usr/local/bin/composer";
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deploy:composer {stage} {--refresh}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'if refresh option, delete current files before compose install';

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
        $isRefresh = $this->option('refresh');
        $stage = $this->argument('stage');
        if($isRefresh){
            //delete files
            //TODO reflesh option
        }

        $deployHelper = new DeployHelper;
        $deployHelper->setStage($stage);

        $composerScript = self::COMPOSER_PATH . " install";
        $inDockerScript = $deployHelper->getInDockerScript($composerScript);
        $inHostScript = $deployHelper->getInHostScript($inDockerScript);
        $sshScript = $deployHelper->getSshScript($inHostScript);

        dump('exec:' . $sshScript);
        $return = exec($sshScript, $arr, $arr2);
        dump($return);
        dump($arr);
        dump($arr2);
    }


}
