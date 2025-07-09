<?php

namespace Php\Project\GenDiff;

use function Php\Project\Parser\parse;
use function Funct\Collection\sortBy;

function generateDiff(string $pathToFile1, string $pathToFile2): string
{
    $parsedFile1 = parse($pathToFile1);
    $parsedFile2 = parse($pathToFile2);

    $diff = buildDiff($parsedFile1, $parsedFile2);

    return formatDiff($diff);
}

function buildDiff(array $data1, array $data2): array
{
    $sortedUniqueKeys = sortBy(
        array_unique(array_merge(array_keys($data1), array_keys($data2))),
        fn($key) => $key
    );

    $diff = [];

    foreach ($sortedUniqueKeys as $key) {
        $keyExistsIn1 = array_key_exists($key, $data1);
        $keyExistsIn2 = array_key_exists($key, $data2);

        $value1 = $keyExistsIn1 ? $data1[$key] : null;
        $value2 = $keyExistsIn2 ? $data2[$key] : null;

        if ($keyExistsIn1 && !$keyExistsIn2) {
            $diff[$key] = ['status' => 'removed', 'value' =>$value1];
        } elseif (!$keyExistsIn1 && $keyExistsIn2) {
            $diff[$key] = ['status' => 'added', 'value' => $value2];
        } elseif ($value1 === $value2) {
            $diff[$key] = ['status' => 'unchanged', 'value' => $value1];
        } else {
            $diff[$key] = ['status' => 'changed', 'oldValue' => $value1, 'newValue' => $value2];
        }
    }

    return $diff;
}

function formatDiff(array $diff): string
{
    $lines = ['{'];

    foreach ($diff as $key => $info) {
        switch ($info['status']) {
            case 'added':
                $lines[] = "  + {$key}: " . formatValue($info['value']);
                break;
            case 'removed':
                $lines[] = "  - {$key}: " . formatValue($info['value']);
                break;
            case 'unchanged':
                $lines[] = "    {$key}: " . formatValue($info['value']);
                break;
            case 'changed':
                $lines[] = "  - {$key}: " . formatValue($info['oldValue']);
                $lines[] = "  + {$key}: " . formatValue($info['newValue']);
                break;
        }
    }

    $lines[] = "}";

    return implode("\n", $lines);
}

function formatValue(mixed $value): string
{
    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }
    if (is_null($value)) {
        return 'null';
    }
    return $value;
}
