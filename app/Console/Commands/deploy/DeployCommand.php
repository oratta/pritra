<?php
namespace App\Console\Commands\deploy;
use App\Console\Helper\DeployHelper as DeployHelper;

trait DeployCommand{
    protected function execArtisanCommand($command, $dryRun=false)
    {
        $stage = $this->argument('stage');

        $deployHelper = new DeployHelper;
        $deployHelper->setStage($stage);

        $execScript = $deployHelper->getExecScript($command);

        dump('exec:' . $execScript);
        if(!$dryRun){
            system($execScript);
        }
    }
}