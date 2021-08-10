<?php

declare(strict_types=1);

namespace App\Commands;

use App\Repositories\ConfigRepository;
use LaravelZero\Framework\Commands\Command;

abstract class FathomCommand extends Command
{
    public function __construct(
        protected ConfigRepository $config,
    ) {
        parent::__construct();
    }
}
