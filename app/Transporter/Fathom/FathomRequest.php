<?php

declare(strict_types=1);

namespace App\Transporter\Fathom;

use App\Repositories\ConfigRepository;
use JustSteveKing\Transporter\Request;

abstract class FathomRequest extends Request
{
    protected string $method = "GET";

    protected string $baseUrl = "https://api.usefathom.com/api/v1/";

    public function authenticate(): self
    {
        /**
         * @var ConfigRepository
         */
        $config = resolve(ConfigRepository::class);

        $this->request->withToken(
            token: $config->get('token'),
        )->withHeaders(
            headers: [
                'Accept' => 'application/json',
            ]
        )->withUserAgent(
            userAgent: "Fathom CLI v0.0.1",
        );

        return $this;
    }
}
