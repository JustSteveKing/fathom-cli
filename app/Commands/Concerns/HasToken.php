<?php

declare(strict_types=1);

namespace App\Commands\Concerns;

trait HasToken
{
    protected function hasToken(): bool
    {
        return config('fathom.token') !== null && config('fathom.token') !== '';
    }

    protected function ensureHasToken(): bool
    {
        if (! $this->hasToken()) {
            $this->error('You have not configured your Fathom API Token yet.');

            return false;
        }

        return true;
    }
}
