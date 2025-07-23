<?php

namespace Differ\Parsers;

use Symfony\Component\Yaml\Yaml;

function parse(string $filePath): \stdClass
{
    $fullPathToFile = realpath($filePath);

    if ($fullPathToFile === false) {
        throw new \InvalidArgumentException("File not found or path is invalid: {$filePath}");
    }

    $fileContent = file_get_contents($fullPathToFile);

    if ($fileContent === false) {
        throw new \RuntimeException("Failed to read file: {$fullPathToFile}");
    }

    $fileExtension = strtolower(pathinfo($fullPathToFile, PATHINFO_EXTENSION));
    return match ($fileExtension) {
        'json' => json_decode($fileContent),
        'yml', 'yaml' => Yaml::parse($fileContent, Yaml::PARSE_OBJECT_FOR_MAP),
        default => throw new \InvalidArgumentException("Unsupported file extension: {$fileExtension}"),
    };
}
