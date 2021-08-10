<?php

declare(strict_types=1);

namespace App\Commands\Sites;

use App\Commands\FathomCommand;
use App\Transporter\Fathom\Sites\CreateRequest;
use Illuminate\Console\Command;

class CreateCommand extends FathomCommand
{
    protected $signature = 'sites:create';

    protected $description = 'Create a new site on fathom.';

    /**
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function handle(): int
    {
        $sharing = [
            'none' => 'No sharing right now.',
            'private' => 'Allow this site to be privately shared (requires a shared password).',
            'public' => 'Set this site to be public.'
        ];

        $name = $this->ask(
            question: '<fg=yellow>‣</> <options=bold>What is the name of this site?</>',
        );

        $share = $this->menu('What share setting do you want to use?', $sharing)->open();

        if (! array_key_exists($share, $sharing)) {
            $this->warn(
                string: "You need to select a privacy option for the site [$name]",
            );
            return Command::INVALID;
        }

        $password = null;

        if ($share === 'private') {
            $password = $this->ask(
                question: 'Please set a password for this site:',
            );
        }

        $response = CreateRequest::build()
            ->authenticate()
            ->withData(
                data: [
                    'name' => $name,
                    'sharing' => $share,
                    'password' => $password,
                ],
            )->send();

        if ($response->failed()) {
            throw $response->toException();
        }

        $this->info(
            string: "Site [$name] has been created.",
        );

        return Command::SUCCESS;
    }
}
