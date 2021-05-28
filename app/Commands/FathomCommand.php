<?php

declare(strict_types=1);

namespace App\Commands;

use App\Commands\Concerns\HasToken;
use App\Commands\Concerns\HasFathomConfig;
use LaravelZero\Framework\Commands\Command;

abstract class FathomCommand extends Command
{
    use HasToken;
    use HasFathomConfig;
}
