<?php

namespace App\Console\Helper;

use Symfony\Component\Yaml\Yaml as Yaml;

class DeployHelper
{
    private $deployPath;
    private $laradockPath;
    private $laradockHostPath;
    private $projectPath;
    private $hostName;

    public function __construct()
    {

    }

    public function setStage($stage)
    {
        $deployerHostsInfo = Yaml::parseFile(base_path('env_files/deployer_hosts.yml'));
        $hostEnv = $deployerHostsInfo[$stage];
        $this->deployPath = $hostEnv['deploy_path'];
        $this->laradockPath = $hostEnv['laradock_path'];
        $this->laradockHostPath = $hostEnv['laradock_host_path'];
        $this->projectPath = $hostEnv['project_path'];
        $this->hostName = $hostEnv['hostname'];
    }

    /**
     * Docker内のホストで実行するスクリプト
     * @param Dockerホスト内のプロジェクトディレクリで実行するメインスクリプト
     *
     */
    public function getInDockerScript($mainScript)
    {
        $inDockerCurrentPath = str_replace($this->projectPath, $this->laradockHostPath, "$this->deployPath/current");
        $inDockerCdScript = "cd $inDockerCurrentPath";
        $laradockHostScript = "$inDockerCdScript && $mainScript";

        return $laradockHostScript;
    }

    /**
     * @param $mainScript ホスト内のプロジェクトディレクトリで実行するスクリプト
     */
    public function getInHostScript($mainScript)
    {
        return "cd $this->laradockPath && sudo docker-compose exec --user=laradock workspace bash -c '$mainScript'";
    }

    public function getSshScript($mainScript)
    {
        $sshScript = "ssh $this->hostName ";
        return $sshScript . '"' . $mainScript . '"';
    }

    public function getExecScript($mainScript)
    {
        $inDockerScript = $this->getInDockerScript($mainScript);
        $inHostScript = $this->getInHostScript($inDockerScript);
        $sshScript = $this->getSshScript($inHostScript);
        return $sshScript;
    }
}
