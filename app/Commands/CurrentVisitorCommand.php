<?php

declare(strict_types=1);

namespace App\Commands;

use App\Transporter\Fathom\CurrentVisitorRequest;
use Illuminate\Console\Command;

class CurrentVisitorCommand extends FathomCommand
{
    protected $signature = 'sites:current-visitors {id : The fathom site ID}';

    protected $description = 'Fetch the current visitors on a site.';

    /**
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function handle(): int
    {
        $this->info(
            string: 'Endpoint not yet active.'
        );

        return Command::SUCCESS;
    }
}
