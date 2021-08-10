<?php

declare(strict_types=1);

namespace App\Commands\Sites;

use App\Commands\FathomCommand;
use App\Transporter\Fathom\Sites\ListRequest;
use Illuminate\Console\Command;

class ListCommand extends FathomCommand
{
    protected $signature = 'sites:list';

    protected $description = 'List all sites on fathom.';

    /**
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function handle(): int
    {
        $response = ListRequest::build()
            ->authenticate()
            ->send();

        if ($response->failed()) {
            throw $response->toException();
        }

        $this->table(
            headers: [
                'id',
                'name',
                'sharing',
             ],
            rows: $response->collect('data')->map(function ($site) {
                return [
                    $site['id'],
                    $site['name'],
                    $site['sharing'],
                ];
            }),
        );

        return Command::SUCCESS;
    }
}
