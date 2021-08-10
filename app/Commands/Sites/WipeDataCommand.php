<?php

declare(strict_types=1);

namespace App\Commands\Sites;

use App\Commands\FathomCommand;
use App\Transporter\Fathom\Sites\WipeRequest;
use Illuminate\Console\Command;

use function _PHPStan_8f2e45ccf\RingCentral\Psr7\str;

class WipeDataCommand extends FathomCommand
{
    protected $signature = 'sites:wipe {id : The fathom site ID}';

    protected $description = 'Wipe the data from the passed through site, this action cannot be undone.';

    /**
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function handle(): int
    {
        if ($this->confirm('Are you sure? This cannot be undone')) {
            $this->info(
                string: 'Wiping site data ...',
            );

            $response = WipeRequest::build()
                ->authenticate()
                ->setPath(
                    path: 'sites/' . $this->argument('id') . '/data',
                )->send();

            if ($response->failed()) {
                throw $response->toException();
            }

            $this->info(
                string: 'Data successfully wiped for site.',
            );

            return Command::SUCCESS;
        }

        $this->info(
            string: 'Phew, that was close. No action taken.'
        );

        return Command::SUCCESS;
    }
}
