<?php

namespace Php\Project\GenDiff\Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use function Php\Project\GenDiff\generateDiff;

class GenDiffTest extends TestCase
{
    public function getFixtureFullPath(string $fixtureName): string
    {
        $parts = [__DIR__, 'fixtures', $fixtureName];
        $fullPath = realpath(implode(DIRECTORY_SEPARATOR, $parts));

        if ($fullPath === false) {
            throw new \RuntimeException("File not found: " . implode('/', $parts));
        }

        return $fullPath;
    }

    public function getFileContents(string $fixtureName): string
    {
        $content = file_get_contents($this->getFixtureFullPath($fixtureName));
        if ($content === false) {
            throw new \RuntimeException("Failed to read the file: " . $fixtureName);
        }
        return $content;
    }

    #[DataProvider('generateDiffProvider')]
    public function testGenerateDiff(string $argument1, string $argument2): void
    {
        $expected = $this->getFileContents('expected.diff');
        $file1 = $this->getFixtureFullPath($argument1);
        $file2 = $this->getFixtureFullPath($argument2);

        $this->assertEquals($expected, generateDiff($file1, $file2));
    }

    public static function generateDiffProvider(): array
    {
        return [
            "json files" => ['file1.json', 'file2.json'],
            "yaml files" => ['file1.yaml', 'file2.yaml'],
        ];
    }
}
