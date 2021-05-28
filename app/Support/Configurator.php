<?php

declare(strict_types=1);

namespace App\Support;

use Symfony\Component\Yaml\Yaml;
use Throwable;

class Configurator
{
    protected array $config;

    public function __construct()
    {
        try {
            $this->config = Yaml::parseFile(getcwd() . 'fathom.yml');
        } catch(Throwable) {
            $this->config = [];
        }
    }

    public function init(string $site, string $path): void
    {
        $configFile = $path . 'fathom.yml';

        $this->config['site'] = $this->getConfigFormat(
            site: $site,
            path: $path,
        );

        $this->store(
            configFile: $configFile,
        );
    }

    public function store(string $configFile): void
    {
        $content = Yaml::dump(
            input: $this->config,
            inline: 4,
            indent: 2,
            flags: Yaml::DUMP_EMPTY_ARRAY_AS_SEQUENCE,
        );

        file_put_contents($configFile, $content);
    }

    public function getConfigFormat(string $site, string $path): array
    {
        return [
            'id' => 'id',
            'site' => $site,
            'path' => $path,
        ];
    }
}
