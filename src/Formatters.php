<?php

namespace Differ\Formatters;

use function Differ\Formatters\Stylish\formatStylish;
use function Differ\Formatters\Plain\formatPlain;

function formatDiff(array $diff, string $format = 'stylish'): string
{

    $formattedOutput = match ($format) {
        'stylish' => formatStylish($diff),
        'plain' => formatPlain($diff),
        default => throw new \Exception("Unknown format: {$format}"),
    };
    return $formattedOutput;
}
