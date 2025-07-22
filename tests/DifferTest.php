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
        $expectedDiff = include $this->getFixtureFullPath($expected);
        $file1 = parse($this->getFixtureFullPath($argument1));
        $file2 = parse($this->getFixtureFullPath($argument2));

        $this->assertEquals($expectedDiff, buildDiff($file1, $file2));
    }

    public static function buildDiffProvider(): array
    {
        return [
            "json files" => ['diff.php', 'file1.json', 'file2.json'],
            "yaml files" => ['diff.php', 'file1.yaml', 'file2.yaml'],
        ];
    }
}
