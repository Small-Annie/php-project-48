<?php

namespace Differ\Formatters\Json;

function formatDiffToJson(array $diff): string
{
    return json_encode($diff, JSON_PRETTY_PRINT);
}
