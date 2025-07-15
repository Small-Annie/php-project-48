<?php

namespace Php\Project\Parsers;

use Symfony\Component\Yaml\Yaml;

function parse(string $filePath): \stdClass
{
    $fileContent = file_get_contents($filePath);
    $fileExtension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
    $data = match ($fileExtension) {
        'json' => json_decode($fileContent),
        'yml', 'yaml' => Yaml::parse($fileContent, Yaml::PARSE_OBJECT_FOR_MAP),
        default => throw new \InvalidArgumentException("Unsupported file extension: $fileExtension"),
    };
    return $data;
}
