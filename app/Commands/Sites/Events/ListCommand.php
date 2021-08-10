<?php

declare(strict_types=1);

namespace App\Commands\Sites\Events;

use App\Commands\FathomCommand;
use App\Transporter\Fathom\Sites\Events\ListRequest;
use Illuminate\Console\Command;

class ListCommand extends FathomCommand
{
    protected $signature = 'events:list {id : The fathom site ID}';

    protected $description = 'List all events for a site on fathom.';

    /**
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function handle(): int
    {
        $response = ListRequest::build()
            ->authenticate()
            ->setPath(
                path: 'sites/' . $this->argument('id') . '/events',
            )->send();

        if ($response->failed()) {
            throw $response->toException();
        }

        $this->table(
            headers: [
                'id',
                'name',
            ],
            rows: $response->collect('data')->map(function ($event) {
                return [
                    $event['id'],
                    $event['name'],
                ];
            }),
        );

        return Command::SUCCESS;
    }
}
