<?php

namespace Differ\Differ\Formatters\Tests;

use Differ\Tests\BaseTestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use function Differ\Formatters\formatDiff;

class FormattersTest extends BaseTestCase
{
    #[DataProvider('formatDiffProvider')]
    public function testFormatDiff(string $expectedFormattedFile, string $diffFile, string $format = 'stylish'): void
    {
        $expectedFormattedContent = $this->getFileContents($expectedFormattedFile);
        $diffContent = include $this->getFixtureFullPath($diffFile);
        $actualFormattedContent = formatDiff($diffContent, $format);

        $this->assertEquals($expectedFormattedContent, $actualFormattedContent);
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