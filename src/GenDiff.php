<?php

namespace Php\Project\GenDiff;

use function Php\Project\Parsers\parse;
use function Funct\Collection\sortBy;

function generateDiff(string $firstFile, string $secondFile): array
{
    $firstFilePath = realpath($firstFile);
    $secondFilePath = realpath($secondFile);

    $firstFileParsed = parse($firstFilePath);
    $secondFileParsed = parse($secondFilePath);

    $diff = buildDiff($firstFileParsed, $secondFileParsed);

    return $diff;
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
            $diff[$key] = createNode('nested', buildDiff($value1, $value2));
        } elseif ($keyExistsIn1 && !$keyExistsIn2) {
            $diff[$key] = createNode('removed', $value1);
        } elseif (!$keyExistsIn1 && $keyExistsIn2) {
            $diff[$key] = createNode('added', $value2);
        } elseif ($value1 === $value2) {
            $diff[$key] = createNode('unchanged', $value1);
        } else {
            $diff[$key] = createNode('changed', $value1, $value2);
        }
    }

    return $diff;
}

function createNode(string $status, $value1, $value2 = null): array
{
    $node = ['status' => $status];
    $value1 = objectToArray($value1);
    $value2 = objectToArray($value2);

    if ($status === 'changed') {
        $node['oldValue'] = $value1;
        $node['newValue'] = $value2;
    } elseif ($status === 'nested') {
        $node['children'] = $value1;
    } else {
        $node['value'] = $value1;
    }

    return $node;
}

function objectToArray(mixed $data): mixed
{
    if (is_object($data)) {
        $data = get_object_vars($data);
    }
    if (is_array($data)) {
        return array_map(fn($item) => objectToArray($item), $data);
    }
    return $data;
}
