<?php

namespace Php\Project\GenDiff;

use function Php\Project\Parser\parse;

function generateDiff($pathToFile1, $pathToFile2): void
{
    $parsedFile1 = parse($pathToFile1);
    $$parsedFile2 = parse($pathToFile2);

    print_r($parsedFile1);
    print_r($parsedFile2);
}