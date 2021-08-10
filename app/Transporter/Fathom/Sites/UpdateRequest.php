<?php

declare(strict_types=1);

namespace App\Transporter\Fathom\Sites;

use App\Transporter\Fathom\FathomRequest;

class UpdateRequest extends FathomRequest
{
    public string $method = 'POST';
}
