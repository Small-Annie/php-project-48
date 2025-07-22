<?php

namespace Differ\Formatters\Plain;

use function Funct\Collection\flattenAll;

function formatDiffToPlain(array $diff): string
{
    $iter = function (array $node, string $parentPath = '') use (&$iter): array {
        return array_map(function ($item) use ($iter, $parentPath) {
            $key = $item['key'];
            $propertyPath = $parentPath === '' ? $key : "{$parentPath}.{$key}";
            $formattedLine = '';

            switch ($item['status']) {
                case 'added':
                    $value = formatValue($item['value']);
                    $formattedLine = "Property '{$propertyPath}' was added with value: {$value}";
                    break;

                case 'removed':
                    $formattedLine = "Property '{$propertyPath}' was removed";
                    break;

                case 'changed':
                    $oldValue = formatValue($item['oldValue']);
                    $newValue = formatValue($item['newValue']);
                    $formattedLine = "Property '{$propertyPath}' was updated. From {$oldValue} to {$newValue}";
                    break;

                case 'nested':
                    $formattedLine = $iter($item['children'], $propertyPath);
                    break;

                case 'unchanged':
                    $formattedLine = [];
                    break;

                default:
                    throw new \InvalidArgumentException("Unknown status '{$item['status']}' for key '{$key}'");
            }
            return $formattedLine;
        }, $node);
    };

    $lines = flattenAll($iter($diff));
    return implode("\n", array_filter($lines));
}

function formatValue(mixed $value): string
{
    return match (true) {
        is_array($value) => '[complex value]',
        is_bool($value) => $value ? 'true' : 'false',
        is_int($value) || is_float($value) => (string) $value,
        is_null($value) => 'null',
        default => "'{$value}'",
    };
}
