<?php

namespace Differ\Formatters\Stylish;

function formatStylish(array $diff, int $depth = 1, string $indent = '    '): string
{
    $lines = [];
    $currentIndent = str_repeat($indent, $depth);
    $prefixIndent = substr($currentIndent, 0, -2);
    $closingIndent = str_repeat($indent, $depth - 1);

    foreach ($diff as $key => $info) {
        switch ($info['status']) {
            case 'added':
                $lines[] = "{$prefixIndent}+ {$key}: " . toString($info['value'], $depth, $indent);
                break;
            case 'removed':
                $lines[] = "{$prefixIndent}- {$key}: " . toString($info['value'], $depth, $indent);
                break;
            case 'unchanged':
                $lines[] = "{$currentIndent}{$key}: " . toString($info['value'], $depth, $indent);
                break;
            case 'changed':
                $lines[] = "{$prefixIndent}- {$key}: " . toString($info['oldValue'], $depth, $indent);
                $lines[] = "{$prefixIndent}+ {$key}: " . toString($info['newValue'], $depth, $indent);
                break;
            case 'nested':
                $lines[] = "{$currentIndent}{$key}: " . formatStylish($info['children'], $depth + 1, $indent);
                break;
        }
    }

    return "{\n" . implode("\n", $lines) . "\n{$closingIndent}}";
}

function toString(mixed $value, int $depth = 1, string $indent = '    '): string
{
    if (is_array($value)) {
        return stringify($value, $depth, $indent);
    }
    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }
    if (is_null($value)) {
        return 'null';
    }
    return trim(var_export($value, true), "'");
}

function stringify(array $value, int $depth = 1, string $indent = '    '): string
{
    $iter = function ($currentValue, $depth) use (&$iter, $indent) {
        $currentIndent = str_repeat($indent, $depth);
        $nestedIndent = str_repeat($indent, $depth + 1);
        $lines = array_map(
            function ($key, $val) use ($iter, $depth, $indent, $nestedIndent) {
                if (is_array($val)) {
                    return "{$nestedIndent}{$key}: " . $iter($val, $depth + 1);
                }
                return "{$nestedIndent}{$key}: " . toString($val, $depth, $indent);
            },
            array_keys($currentValue),
            $currentValue
        );
        $result = ['{', ...$lines, "{$currentIndent}}"];

        return implode("\n", $result);
    };

    return $iter($value, $depth);
}
