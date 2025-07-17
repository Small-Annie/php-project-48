<?php

namespace Php\Project\Formatters\Tests;

use Php\Project\Tests\BaseTestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use function Php\Project\Formatters\formatDiff;

class FormattersTest extends BaseTestCase
{
    #[DataProvider('formatDiffProvider')]
    public function testFormatDiff(string $expected, string $argument): void
    {
        $expectedFormat = $this->getFileContents($expected);
        $diffContent = json_decode($this->getFileContents($argument), true);
        $actualFormat = formatDiff($diffContent);

        $this->assertEquals($expectedFormat, $actualFormat);
    }

    public static function formatDiffProvider(): array
    {
        return [
            "stylish" => ['diffFormat.stylish', 'diff.json'],
        ];
    }
}