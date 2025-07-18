<?php

namespace Differ\Differ;

use function Differ\Parsers\parse;
use function Differ\Formatters\formatDiff;
use function Funct\Collection\sortBy;

function genDiff(string $path1, string $path2, string $format = 'stylish'): string
{
    $parsedFile1 = parse($path1);
    $parsedFile2 = parse($path2);

    $diff = buildDiff($parsedFile1, $parsedFile2);

    return formatDiff($diff, $format);
}

function buildDiff(object $data1, object $data2): array
{
    $sortedUniqueKeys = sortBy(
        array_unique(
            array_merge(
                array_keys(get_object_vars($data1)),
                array_keys(get_object_vars($data2))
            )
        ),
        fn($key) => $key
    );

    $diff = [];

    foreach ($sortedUniqueKeys as $key) {
        $keyExistsIn1 = property_exists($data1, $key);
        $keyExistsIn2 = property_exists($data2, $key);

        $value1 = $keyExistsIn1 ? $data1->$key : null;
        $value2 = $keyExistsIn2 ? $data2->$key : null;

        if (is_object($value1) && is_object($value2)) {
            $diff[] = createNode($key, 'nested', buildDiff($value1, $value2));
        } elseif ($keyExistsIn1 && !$keyExistsIn2) {
            $diff[] = createNode($key, 'removed', $value1);
        } elseif (!$keyExistsIn1 && $keyExistsIn2) {
            $diff[] = createNode($key, 'added', $value2);
        } elseif ($value1 === $value2) {
            $diff[] = createNode($key, 'unchanged', $value1);
        } else {
            $diff[] = createNode($key, 'changed', $value1, $value2);
        }
    }

    return $diff;
}

function createNode(string $key, string $status, $value1, $value2 = null): array
{
    $node = ['key' => $key, 'status' => $status];

    $value1 = convertObjects($value1);
    $value2 = convertObjects($value2);

    $valueFields = match ($status) {
        'changed' => ['oldValue' => $value1, 'newValue' => $value2],
        'nested' => ['children' => $value1],
        default => ['value' => $value1],
    };

    $node += $valueFields;

    return $node;
}

function convertObjects(mixed $data): mixed
{
    return match (true) {
        is_object($data) => convertObjects(get_object_vars($data)),
        is_array($data) => array_map(fn($item) => convertObjects($item), $data),
        default => $data,
    };
}
