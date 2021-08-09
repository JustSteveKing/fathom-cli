<?php

declare(strict_types=1);

namespace App\Commands;

use Illuminate\Console\Command;
use Throwable;

class SetupCommand extends FathomCommand
{
    protected $signature = 'setup';

    protected $description = 'Setup the Fathom CLI using your API token.';

    /**
     * @throws Throwable
     */
    public function handle(): int
    {
        $token = $this->ask(
            question: '<fg=yellow>‣</> <options=bold>Please enter your API token</>',
        );

        try {
            $this->config->set('token', $token);
        } catch(Throwable $e) {
            throw $e;
        }

        $this->info(
            string: 'API Token stored successfully',
        );

        return Command::SUCCESS;
    }
}
