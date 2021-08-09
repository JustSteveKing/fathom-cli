<?php

use Illuminate\Console\Command;

it('can run the setup command', function () {
    $this->artisan('setup')
        ->expectsQuestion(
            '<fg=yellow>‣</> <options=bold>Please enter your API token</>',
            '1234',
        )->assertExitCode(Command::SUCCESS);
});
