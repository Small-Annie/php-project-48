<?php

namespace Differ\Formatters\Stylish;

function formatDiffToStylish(array $diff): string
{
    $indent = '    ';
    $iter = function (array $node, int $depth) use (&$iter, $indent): array {
        $currentIndent = str_repeat($indent, $depth);
        $prefixIndent = substr($currentIndent, 0, -2);

        return array_map(function ($item) use ($iter, $depth, $currentIndent, $prefixIndent) {
            $key = $item['key'];

            switch ($item['status']) {
                case 'added':
                    $valueStr = toString($item['value'], $depth);
                    $formattedLine = "{$prefixIndent}+ {$key}: {$valueStr}";
                    break;
                case 'removed':
                    $valueStr = toString($item['value'], $depth);
                    $formattedLine = "{$prefixIndent}- {$key}: {$valueStr}";
                    break;
                case 'unchanged':
                    $valueStr = toString($item['value'], $depth);
                    $formattedLine = "{$currentIndent}{$key}: {$valueStr}";
                    break;
                case 'changed':
                    $oldValueStr = toString($item['oldValue'], $depth);
                    $newValueStr = toString($item['newValue'], $depth);
                    $removedLine = "{$prefixIndent}- {$key}: {$oldValueStr}";
                    $addedLine = "{$prefixIndent}+ {$key}: {$newValueStr}";
                    $formattedLine = "{$removedLine}\n{$addedLine}";
                    break;
                case 'nested':
                    $childrenLines = $iter($item['children'], $depth + 1);
                    $childrenStr = implode("\n", $childrenLines);
                    $formattedLine = "{$currentIndent}{$key}: {\n{$childrenStr}\n{$currentIndent}}";
                    break;
                default:
                    throw new \InvalidArgumentException("Unknown status '{$item['status']}' for key '{$key}'");
            }
            return $formattedLine;
        }, $node);
    };

    $lines = $iter($diff, 1);
    $linesString = implode("\n", $lines);
    return "{\n{$linesString}\n}";
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
                    $nestedStr = $iter($val, $depth + 1);
                    return "{$nestedIndent}{$key}: {$nestedStr}";
                }
                $valStr = toString($val, $depth);
                return "{$nestedIndent}{$key}: {$valStr}";
            },
            array_keys($currentValue),
            $currentValue
        );
        $result = ['{', ...$lines, "{$currentIndent}}"];

        return implode("\n", $result);
    };

    return $iter($value, $depth);
}
