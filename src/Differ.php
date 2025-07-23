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

    return array_reduce(
        $sortedUniqueKeys,
        function (array $diff, string $key) use ($data1, $data2): array {
            $hasKeyInData1 = property_exists($data1, $key);
            $hasKeyInData2 = property_exists($data2, $key);

            $value1 = $hasKeyInData1 ? $data1->$key : null;
            $value2 = $hasKeyInData2 ? $data2->$key : null;

            $node = match (true) {
                is_object($value1) && is_object($value2) => createNode($key, 'nested', buildDiff($value1, $value2)),
                $hasKeyInData1 && !$hasKeyInData2 => createNode($key, 'removed', $value1),
                !$hasKeyInData1 && $hasKeyInData2 => createNode($key, 'added', $value2),
                $value1 === $value2 => createNode($key, 'unchanged', $value1),
                default => createNode($key, 'changed', $value1, $value2),
            };

            return [...$diff, $node];
        },
        []
    );
}

function createNode(string $key, string $status, mixed $value1, mixed $value2 = null): array
{
    $value1 = convertObjects($value1);
    $value2 = convertObjects($value2);

    $nodeValues = match ($status) {
        'changed' => ['oldValue' => $value1, 'newValue' => $value2],
        'nested' => ['children' => $value1],
        default => ['value' => $value1],
    };

    return array_merge(
        ['key' => $key, 'status' => $status],
        $nodeValues
    );
}

function convertObjects(mixed $data): mixed
{
    return match (true) {
        is_object($data) => convertObjects(get_object_vars($data)),
        is_array($data) => array_map(fn($item) => convertObjects($item), $data),
        default => $data,
    };
}
