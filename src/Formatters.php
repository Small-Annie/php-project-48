<?php

namespace Differ\Formatters;

use function Differ\Formatters\Stylish\formatDiffToStylish;
use function Differ\Formatters\Plain\formatDiffToPlain;
use function Differ\Formatters\Json\formatDiffToJson;

function formatDiff(array $diff, string $format = 'stylish'): string
{
    return match ($format) {
        'stylish' => formatDiffToStylish($diff),
        'plain' => formatDiffToPlain($diff),
        'json' => formatDiffToJson($diff),
        default => throw new \InvalidArgumentException("Unknown format: {$format}"),
    };
}
