<?php

namespace Differ\Tests;

use PHPUnit\Framework\TestCase;

class BaseTestCase extends TestCase
{
    protected function getFixtureFullPath(string $fixtureName): string
    {
        $parts = [__DIR__, 'fixtures', $fixtureName];
        $fullPath = realpath(implode(DIRECTORY_SEPARATOR, $parts));

        if ($fullPath === false) {
            throw new \RuntimeException("File not found: " . implode('/', $parts));
        }

        return $fullPath;
    }

    protected function getFileContents(string $fixtureName): string
    {
        $content = file_get_contents($this->getFixtureFullPath($fixtureName));
        if ($content === false) {
            throw new \RuntimeException("Failed to read the file: " . $fixtureName);
        }
        return $content;
    }
}
