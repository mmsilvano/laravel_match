<?php

declare(strict_types=1);

$compiledViewPath = sys_get_temp_dir().DIRECTORY_SEPARATOR.'laravelmatch-testing-views';

putenv('VIEW_COMPILED_PATH='.$compiledViewPath);
$_ENV['VIEW_COMPILED_PATH'] = $compiledViewPath;
$_SERVER['VIEW_COMPILED_PATH'] = $compiledViewPath;

require __DIR__.'/../vendor/autoload.php';
