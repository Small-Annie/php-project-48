<?php

namespace Php\Project\Parser;

function parse(string $path): array
{
    $fileContent = file_get_contents($path);
    $data = json_decode($fileContent, true);
    return $data;
}