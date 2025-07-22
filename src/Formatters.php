<?php

namespace Differ\Formatters;

use function Differ\Formatters\Stylish\formatStylish;
use function Differ\Formatters\Plain\formatPlain;
use function Differ\Formatters\Json\formatJson;

function formatDiff(array $diff, string $format = 'stylish'): string
{

    $formattedOutput = match ($format) {
        'stylish' => formatStylish($diff),
        'plain' => formatPlain($diff),
        'json' => formatJson($diff),
        default => throw new \Exception("Unknown format: {$format}"),
    };
    return $formattedOutput;
}
