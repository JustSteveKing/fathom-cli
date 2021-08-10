<?php

declare(strict_types=1);

namespace App\Transporter\Fathom\Sites\Reports;

use App\Transporter\Fathom\FathomRequest;

abstract class AggregationRequest extends FathomRequest
{
    protected string $path = 'aggregations';
}
