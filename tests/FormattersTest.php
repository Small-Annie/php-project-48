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
        $diffContent = json_decode($this->getFileContents($argument), true);
        $actualFormat = formatDiff($diffContent, $format);

        $this->assertEquals($expectedFormat, $actualFormat);
    }

    public static function formatDiffProvider(): array
    {
        return [
            "stylish" => ['diffFormat.stylish', 'diff.json'],
            "plain" => ['diffFormat.plain', 'diff.json', 'plain']
        ];
    }
}