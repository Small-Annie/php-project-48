<?php

namespace Differ\Formatters\Json;

function formatDiffToJson(array $diff): string
{
    $json = json_encode($diff, JSON_PRETTY_PRINT);
    if ($json === false) {
        throw new \RuntimeException('JSON encoding failed: ' . json_last_error_msg());
    }
    return $json;
}
