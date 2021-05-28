<?php

namespace App\Commands;

use App\Support\Configurator;
use App\Commands\Concerns\HasToken;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class InitCommand extends Command
{
    use HasToken;

    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'init';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Initialize the current project to track analytics from the Fathom API.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(Configurator $configurator)
    {
        $this->ensureHasToken();

        // call API and get sites. go through a list and allow selection of the correct site.

        $configurator->init(
            'site-name-here',
            getcwd(),
        );
    }

    /**
     * Define the command's schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }
}
