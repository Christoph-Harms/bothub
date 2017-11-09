<?php

namespace BotHub\Console\Commands;

use Illuminate\Console\Command;

class UpdateBothub extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bothub:update
                            {--D|with-dev : Include composer dev dependencies}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pulls in the latest changes from upstream';

    /**
     * Create a new command instance.
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
        $this->info("BotHub update started.");

        $this->pullFromUpstream();

        $this->composerUpdate();
    }

    protected function pullFromUpstream()
    {
        $this->comment("Pulling in latest changes from upstream...");
        system('git pull');
    }

    protected function composerUpdate()
    {
        $command = 'composer update --no-scripts --optimize-autoloader';

        if (! $this->option('with-dev')) {
            $command .= ' --no-dev';
        }

        $this->comment("Performing composer update...");
        system($command);
    }
}
