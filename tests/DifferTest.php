<?php

namespace Differ\Differ\Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

use function Differ\Differ\genDiff;

class DifferTest extends TestCase
{
    private function getFixtureFullPath(string $fixtureName): string
    {
        $parts = [__DIR__, 'fixtures', $fixtureName];
        $fullPath = realpath(implode(DIRECTORY_SEPARATOR, $parts));

        if ($fullPath === false) {
            throw new \RuntimeException("File not found: " . implode('/', $parts));
        }

        return $fullPath;
    }

    private function getFileContents(string $fixtureName): string
    {
        $content = file_get_contents($this->getFixtureFullPath($fixtureName));
        if ($content === false) {
            throw new \RuntimeException("Failed to read the file: " . $fixtureName);
        }
        return $content;
    }

    #[DataProvider('genDiffProvider')]
    public function testGenDiff(string $expectedFormattedFile, string $firstFile, string $secondFile, ?string $format): void
    {
        $expectedFormattedContent = $this->getFileContents($expectedFormattedFile);

        $path1 = $this->getFixtureFullPath($firstFile);
        $path2 = $this->getFixtureFullPath($secondFile);

        $actualFormattedContent = $format === null
            ? genDiff($path1, $path2)
            : genDiff($path1, $path2, $format);

        $this->assertEquals($expectedFormattedContent, $actualFormattedContent);
    }

    public static function genDiffProvider(): array
    {
        return [
            "default (stylish)" => ['diffFormat.stylish', 'file1.json', 'file2.yaml', null],
            "stylish" => ['diffFormat.stylish', 'file1.json', 'file2.yaml', 'stylish'],
            "plain" => ['diffFormat.plain', 'file1.json', 'file2.yaml', 'plain'],
            "json" => ['diffFormat.json', 'file1.json', 'file2.yaml', 'json']
        ];
    }
}
