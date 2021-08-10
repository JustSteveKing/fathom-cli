<?php

declare(strict_types=1);

namespace App\Transporter\Fathom\Sites;

use App\Transporter\Fathom\FathomRequest;

class WipeRequest extends FathomRequest
{
    protected string $method = 'DELETE';
}
