<?php

namespace Differ\Differ\Formatters\Tests;

use Differ\Tests\BaseTestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use function Differ\Formatters\formatDiff;

class FormattersTest extends BaseTestCase
{
    #[DataProvider('formatDiffProvider')]
    public function testFormatDiff(string $expected, string $argument, string $format = 'stylish'): void
    {
        $expectedFormat = $this->getFileContents($expected);
        $diffContent = include $this->getFixtureFullPath($argument);
        $actualFormat = formatDiff($diffContent, $format);

        $this->assertEquals($expectedFormat, $actualFormat);
    }

    public static function formatDiffProvider(): array
    {
        return [
            "stylish" => ['diffFormat.stylish', 'diff.php'],
            "plain" => ['diffFormat.plain', 'diff.php', 'plain'],
            "json" => ['diffFormat.json', 'diff.php', 'json']
        ];
    }
}