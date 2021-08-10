<?php

declare(strict_types=1);

namespace App\Commands\Sites\Events;

class ListCommand extends \App\Commands\FathomCommand
{
    protected $signature = 'events:list';

    protected $description = 'List all events for a site on fathom.';

    /**
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function handle(): int
    {
        //
    }
}
