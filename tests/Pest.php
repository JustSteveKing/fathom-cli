<?php

use Tests\TestCase;
use Tests\CreatesApplication;

uses(TestCase::class, CreatesApplication::class)
    ->beforeEach(function () {
        //
    })->in('Feature', 'Unit');
