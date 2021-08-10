<?php

declare(strict_types=1);

namespace App\Commands\Sites;

use App\Commands\FathomCommand;
use App\Transporter\Fathom\Sites\FetchRequest;
use Carbon\Carbon;
use Illuminate\Console\Command;

class FetchCommand extends FathomCommand
{
    protected $signature = 'sites:fetch {id : The fathom site ID}';

    protected $description = 'Fetch a single site from fathom.';

    /**
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function handle(): int
    {
        $response = FetchRequest::build()
            ->authenticate()
            ->setPath(
                path: 'sites/' . $this->argument('id'),
            )->send();

        if ($response->failed()) {
            throw $response->toException();
        }

        $this->table(
            headers: [
                'id',
                'name',
                'sharing',
                'created',
            ],
            rows: [
                [
                    'id' => $response->json()['id'],
                    'name' => $response->json()['name'],
                    'sharing' => $response->json()['sharing'],
                    'created' => Carbon::parse($response->json()['created_at'])->diffForHumans(),
                ]
            ],
        );

        return Command::SUCCESS;
    }
}
