<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\File;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $compiledViewPath = (string) env(
            'VIEW_COMPILED_PATH',
            sys_get_temp_dir().DIRECTORY_SEPARATOR.'laravelmatch-testing-views',
        );

        File::ensureDirectoryExists($compiledViewPath);

        config()->set('view.compiled', $compiledViewPath);
    }
}
