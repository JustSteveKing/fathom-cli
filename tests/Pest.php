<?php

use App\Repositories\ConfigRepository;
use Illuminate\Filesystem\Filesystem;
use Tests\TestCase;
use Tests\CreatesApplication;

uses(TestCase::class, CreatesApplication::class)
    ->beforeEach(function () {
        (new Filesystem)->deleteDirectory(base_path('tests/.fathom'));

        $this->config = resolve(ConfigRepository::class)->set('token', '123123213');
    })->afterEach(function () {
        (new Filesystem)->deleteDirectory(base_path('tests/.fathom'));
    })->in('Feature', 'Unit');
