<?php

declare(strict_types=1);

namespace App\Commands;

use PhpParser\Parser\Php7;
use PhpParser\NodeTraverser;
use PhpParser\Lexer\Emulative;
use App\Support\TokenNodeVisitor;
use App\Commands\Concerns\HasToken;
use PhpParser\PrettyPrinter\Standard;
use PhpParser\NodeVisitor\CloningVisitor;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class SetupCommand extends Command
{
    use HasToken;

    protected $signature = 'setup {--force}';

    protected $description = 'Setup the Fathom CLI';

    public function handle()
    {
        if ($this->hasToken() && ! $this->option('force')) {
            $this->warn('You have already setup a connection for the Fathom CLI');

            return 0;
        }

        $token = $this->ask('What is your Fathom API Token?');

        $this->info('Setting up your configuration file ...');

        $this->setup(
            token: $token,
        );
    }

    public function setup(string $token): void
    {
        $this->info('Checking Directories');

        $configFile = implode(DIRECTORY_SEPARATOR, [
            $_SERVER['HOME'] ?? $_SERVER['USERPROFILE'],
            '.fathom',
            'config.php',
        ]);

        if (! file_exists($configFile)) {
            $this->info('Config file not yet created, creating ...');
            @mkdir(dirname($configFile), 0777, true);
            $updatedConfigFile = $this->modifyConfigurationFile(base_path('config/fathom.php'), $token);
        } else {
            $this->info('Config file found, modifying .....');
            $updatedConfigFile = $this->modifyConfigurationFile($configFile, $token);
        }

        file_put_contents($configFile, $updatedConfigFile);

        return;
    }

    protected function modifyConfigurationFile(string $configFile, string $token)
    {
        $lexer = new Emulative([
            'usedAttributes' => [
                'comments',
                'startLine', 'endLine',
                'startTokenPos', 'endTokenPos',
            ],
        ]);
        $parser = new Php7($lexer);

        $oldStmts = $parser->parse(file_get_contents($configFile));
        $oldTokens = $lexer->getTokens();

        $nodeTraverser = new NodeTraverser;
        $nodeTraverser->addVisitor(new CloningVisitor());
        $newStmts = $nodeTraverser->traverse($oldStmts);

        $nodeTraverser = new NodeTraverser;
        $nodeTraverser->addVisitor(new TokenNodeVisitor($token));

        $newStmts = $nodeTraverser->traverse($newStmts);

        $prettyPrinter = new Standard();

        return $prettyPrinter->printFormatPreserving($newStmts, $oldStmts, $oldTokens);
    }

    /**
     * Define the command's schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }
}
