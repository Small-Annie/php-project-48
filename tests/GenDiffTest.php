<?php

namespace Php\Project\GenDiff\Tests;

use Php\Project\Tests\BaseTestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use function Php\Project\GenDiff\generateDiff;

class GenDiffTest extends BaseTestCase
{
    #[DataProvider('generateDiffProvider')]
    public function testGenerateDiff(string $expected, string $argument1, string $argument2): void
    {
        $expectedDiff = $this->getFileContents($expected);
        $file1 = $this->getFixtureFullPath($argument1);
        $file2 = $this->getFixtureFullPath($argument2);

        $this->assertEquals($expectedDiff, json_encode(generateDiff($file1, $file2), JSON_PRETTY_PRINT));
    }

    public static function generateDiffProvider(): array
    {
        return [
            "json files" => ['diff.json', 'file1.json', 'file2.json'],
            "yaml files" => ['diff.json', 'file1.yaml', 'file2.yaml'],
        ];
    }
}
