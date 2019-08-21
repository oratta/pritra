<?php

namespace App\Console\Commands\deploy;

use Illuminate\Console\Command;

class ConfigCache extends Command
{
    use DeployCommand;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deploy:config-cache {stage}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'exec "php artisan config:cache" in a {stage} environment';

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
        $this->execArtisanCommand('php artisan config:cache');
    }
}
