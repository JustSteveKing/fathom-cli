<?php

use Illuminate\Console\Command;
use Illuminate\Testing\PendingCommand;

it('');

it('stores the users API token globally', function () {
    /**
     * @var PendingCommand
     */
    $this->artisan(
        command: 'setup',
    )->expectsQuestion(
        question: 'What is your Fathom API Token?',
        answer: '12345',
    )->expectsOutput(
        output: 'Setting up your configuration file ...',
    )->assertExitCode(Command::SUCCESS);
});
