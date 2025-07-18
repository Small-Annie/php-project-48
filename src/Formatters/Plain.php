<?php

namespace Differ\Formatters\Plain;

use function Funct\Collection\flattenAll;

function formatPlain(array $diff): string
{
    $iter = function (array $node, string $parentPath = '') use (&$iter): array {
        return array_map(function ($item) use ($iter, $parentPath) {
            $key = $item['key'];
            $propertyPath = $parentPath === '' ? $key : "{$parentPath}.{$key}";

            switch ($item['status']) {
                case 'added':
                    $value = formatValue($item['value']);
                    return "Property '{$propertyPath}' was added with value: {$value}";

                case 'removed':
                    return "Property '{$propertyPath}' was removed";

                case 'changed':
                    $oldValue = formatValue($item['oldValue']);
                    $newValue = formatValue($item['newValue']);
                    return "Property '{$propertyPath}' was updated. From {$oldValue} to {$newValue}";

                case 'nested':
                    return $iter($item['children'], $propertyPath);

                case 'unchanged':
                    return [];
            }
        }, $node);
    };

    $flattened = flattenAll($iter($diff));
    return implode("\n", array_filter($flattened));
}

function formatValue(mixed $value): string
{
    return match (true) {
        is_array($value) => '[complex value]',
        is_bool($value) => $value ? 'true' : 'false',
        is_null($value) => 'null',
        default => "'{$value}'",
    };
}
