<?php

declare(strict_types=1);

namespace App\Commands\Sites;

use App\Commands\FathomCommand;
use App\Transporter\Fathom\Sites\UpdateRequest;
use Illuminate\Console\Command;

class UpdateCommand extends FathomCommand
{
    protected $signature = 'sites:update
                            {id : The fathom site ID}
                            {--name= : Update the name of this site}
                            {--sharing= : Update the sharing settings of this site}
                            {--password= : Update the sharing password of this site}';

    protected $description = 'Update a specific site on fathom.';

    /**
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function handle(): int
    {
        if (is_null($this->option('name')) && is_null($this->option('sharing')) && is_null($this->option('password'))) {
            $this->warn(
                string: 'You must pass at lease the name, sharing or password option to update a site.',
            );

            return Command::INVALID;
        }

        $data = [];

        if (! is_null($this->option('name'))) {
            $data['name'] = $this->option('name');
        }

        if (! is_null($this->option('sharing'))) {
            $data['sharing'] = $this->option('sharing');
        }

        if (! is_null($this->option('password'))) {
            $data['sharing_password'] = $this->option('password');
        }

        $response = UpdateRequest::build()
            ->authenticate()
            ->setPath(
                path: 'sites/' . $this->argument('id')
            )->withData(
                data: $data,
            )->send();

        if ($response->failed()) {
            throw $response->toException();
        }

        $this->info(
            string: "Updated site.",
        );


        return Command::SUCCESS;
    }
}
