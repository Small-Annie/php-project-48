<?php

namespace Differ\Parsers;

use Symfony\Component\Yaml\Yaml;

function parse(string $filePath): \stdClass
{
    $fullPathToFile = realpath($filePath);
    $fileContent = file_get_contents($fullPathToFile);
    $fileExtension = strtolower(pathinfo($fullPathToFile, PATHINFO_EXTENSION));
    return match ($fileExtension) {
        'json' => json_decode($fileContent),
        'yml', 'yaml' => Yaml::parse($fileContent, Yaml::PARSE_OBJECT_FOR_MAP),
        default => throw new \InvalidArgumentException("Unsupported file extension: {$fileExtension}"),
    };
}
