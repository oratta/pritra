<?php

namespace App\Console\Commands\deploy;

use Illuminate\Console\Command;
use Symfony\Component\Yaml\Yaml as Yaml;

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


        //composer install via docker-compose
        $deployerHostsInfo = Yaml::parseFile(base_path('env_files/deployer_hosts.yml'));
        $hostEnv = $deployerHostsInfo[$stage];
        $deployPath = $hostEnv['deploy_path'];
        $laradockPath = $hostEnv['laradock_path'];
        $laradockHostPath = $hostEnv['laradock_host_path'];
        $projectPath = $hostEnv['project_path'];

        $hostName = $hostEnv['hostname'];
        $inDockerCurrentPath = str_replace($projectPath, $laradockHostPath, "$deployPath/current");
        $inDockerCdScript = "cd $inDockerCurrentPath";
        $composerScript = self::COMPOSER_PATH . " install";
        $laradockHostScript = "bash -c '$inDockerCdScript && $composerScript'";

        $mainScript = "cd $laradockPath && sudo docker-compose exec --user=laradock workspace $laradockHostScript";

        $sshScript = "ssh $hostName ";

        $execScript = $sshScript . '"' . $mainScript . '"';

        dump('exec:' . $execScript);
        $return = exec($execScript, $arr, $arr2);
        dump($return);
        dump($arr);
        dump($arr2);


    }
}
