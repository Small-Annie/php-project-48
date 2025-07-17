<?php

namespace Php\Project\Formatters;

use function Php\Project\Formatters\Stylish\formatStylish;

function formatDiff(array $diff, string $format = 'stylish'): string
{

    $formattedOutput = match ($format) {
        'stylish' => formatStylish($diff),
        default => throw new \Exception("Unknown format: {$format}"),
    };
    return $formattedOutput;
}
