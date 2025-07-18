<?php

namespace Differ\Differ\Tests;

use Differ\Tests\BaseTestCase;
use PHPUnit\Framework\Attributes\DataProvider;

use function Differ\Differ\buildDiff;
use function Differ\Parsers\parse;


class DifferTest extends BaseTestCase
{
    #[DataProvider('buildDiffProvider')]
    public function testBuildDiff(string $expected, string $argument1, string $argument2): void
    {
        $expectedDiff = $this->getFileContents($expected);
        $file1 = parse($this->getFixtureFullPath($argument1));
        $file2 = parse($this->getFixtureFullPath($argument2));

        $this->assertEquals($expectedDiff, json_encode(buildDiff($file1, $file2), JSON_PRETTY_PRINT));
    }

    public static function buildDiffProvider(): array
    {
        return [
            "json files" => ['diff.json', 'file1.json', 'file2.json'],
            "yaml files" => ['diff.json', 'file1.yaml', 'file2.yaml'],
        ];
    }
}
