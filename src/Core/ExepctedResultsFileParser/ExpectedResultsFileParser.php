<?php

declare(strict_types=1);


namespace DaveLiddament\StaticAnalyserAnalyser\Core\ExepctedResultsFileParser;


use DaveLiddament\StaticAnalyserAnalyser\Core\Common\LineNumber;

class ExpectedResultsFileParser
{

    /**
     * Returns all the ExpectedResults found in a file.
     *
     * @return ExpectedResult[]
     */
    public function getExpectedResults(string $fileContents): array
    {
        $expectedResults = [];

        $lines = explode(PHP_EOL, $fileContents);
        foreach($lines as $index => $line) {
            $lineNumber = $index + 1;

            if (strpos($line, '// ISSUE') !== false) {
                $expectedResults[] = new ExpectedResult(ExpectedResult::ISSUE, new LineNumber($lineNumber));
            }

            if (strpos($line, '// OK') !== false) {
                $expectedResults[] = new ExpectedResult(ExpectedResult::OK, new LineNumber($lineNumber));
            }

            if (strpos($line, '// OPTIONAL') != false) {
                $expectedResults[] = new ExpectedResult(ExpectedResult::OPTIONAL, new LineNumber($lineNumber));
            }
        }

        return $expectedResults;
    }

}
