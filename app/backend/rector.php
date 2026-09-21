<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\SetList;

// Used by the "Build a PHP Migration MCP Tool" task (lesson 09).
// The MCP server's `run_migration` tool wraps `vendor/bin/rector process --set phpXY`.
return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/src',
        __DIR__ . '/public',
    ])
    ->withSets([
        SetList::PHP_82,
    ]);
