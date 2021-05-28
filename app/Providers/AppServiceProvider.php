<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        //
    }

    public function register(): void
    {
        // $this->loadConfig();
    }

    protected function loadConfig(): void
    {
        $config = config('fathom');

        $configFile = implode(DIRECTORY_SEPARATOR, [
            $_SERVER['HOME'] ?? $_SERVER['USERPROFILE'] ?? __DIR__,
            '.fathom',
            'config.php',
        ]);

        if (file_exists($configFile)) {
            $globalConfig = require $configFile;

            config()->set('fathom', array_merge($config, $globalConfig));
        }
    }
}
