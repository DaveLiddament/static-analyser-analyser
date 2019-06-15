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

            foreach(ExpectedResult::VALID_TYPES as $type) {
                $searchTerm = "// $type";
                if (strpos($line, $searchTerm) !== false) {
                    $expectedResults[] = new ExpectedResult($type, new LineNumber($lineNumber));
                }
            }
        }

        return $expectedResults;
    }

}
