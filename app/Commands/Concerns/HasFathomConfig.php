<?php

declare(strict_types=1);

namespace App\Commands\Concerns;

trait HasFathomConfig
{
    public function ensureHasFathomConfig(): bool
    {
        if (! file_exists(getcwd() . '/fathom.yml')) {
            $this->error('You have not linked this project to a Fathom site yet.');

            return false;
        }

        return true;
    }
}
