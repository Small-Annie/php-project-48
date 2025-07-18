<?php

namespace Differ\Formatters\Stylish;

function formatStylish(array $diff): string
{
    $indent = '    ';
    $iter = function (array $node, int $depth) use (&$iter, $indent): array {
        $currentIndent = str_repeat($indent, $depth);
        $prefixIndent = substr($currentIndent, 0, -2);

        return array_map(function ($item) use ($iter, $depth, $currentIndent, $prefixIndent) {
            $key = $item['key'];

            switch ($item['status']) {
                case 'added':
                    return "{$prefixIndent}+ {$key}: " . toString($item['value'], $depth);
                case 'removed':
                    return "{$prefixIndent}- {$key}: " . toString($item['value'], $depth);
                case 'unchanged':
                    return "{$currentIndent}{$key}: " . toString($item['value'], $depth);
                case 'changed':
                    return "{$prefixIndent}- {$key}: " . toString($item['oldValue'], $depth)
                         . "\n"
                         . "{$prefixIndent}+ {$key}: " . toString($item['newValue'], $depth);
                case 'nested':
                    $childrenLines = $iter($item['children'], $depth + 1);
                    $childrenString = implode("\n", $childrenLines);
                    return "{$currentIndent}{$key}: {\n{$childrenString}\n{$currentIndent}}";
                default:
                    return '';
            }
        }, $node);
    };

    $lines = $iter($diff, 1);
    return "{\n" . implode("\n", $lines) . "\n}";
}

function toString(mixed $value, int $depth = 1): string
{
    return match (true) {
        is_array($value) => stringify($value, $depth),
        is_bool($value) => $value ? 'true' : 'false',
        is_null($value) => 'null',
        default => trim(var_export($value, true), "'"),
    };
}

function stringify(array $value, int $depth = 1): string
{
    $indent = '    ';
    $iter = function ($currentValue, $depth) use (&$iter, $indent) {
        $currentIndent = str_repeat($indent, $depth);
        $nestedIndent = str_repeat($indent, $depth + 1);
        $lines = array_map(
            function ($key, $val) use ($iter, $depth, $nestedIndent) {
                if (is_array($val)) {
                    return "{$nestedIndent}{$key}: " . $iter($val, $depth + 1);
                }
                return "{$nestedIndent}{$key}: " . toString($val, $depth);
            },
            array_keys($currentValue),
            $currentValue
        );
        $result = ['{', ...$lines, "{$currentIndent}}"];

        return implode("\n", $result);
    };

    return $iter($value, $depth);
}
