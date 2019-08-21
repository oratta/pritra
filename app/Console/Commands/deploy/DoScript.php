<?php

namespace App\Console\Commands\deploy;

use Illuminate\Console\Command;

class DoScript extends Command
{
    use DeployCommand;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deploy:script {stage} {script}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Do script at {stage} environment';

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
        $this->execArtisanCommand($this->argument('script'));
    }
}
