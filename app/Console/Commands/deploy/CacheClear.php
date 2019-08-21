<?php

namespace App\Console\Commands\deploy;

use App\Console\Helper\DeployHelper as DeployHelper;
use Illuminate\Console\Command;

class CacheClear extends Command
{
    use DeployCommand;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deploy:cache-clear {stage}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "exec 'php artisan cache:clear' in a {stage} environment";

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
        $this->execArtisanCommand("php artisan cache:clear");
    }
}
