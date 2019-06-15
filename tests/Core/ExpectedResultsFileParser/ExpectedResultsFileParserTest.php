<?php

declare(strict_types=1);


namespace DaveLiddament\StaticAnalyserAnalyser\Test\Core\ExpectedResultsParser;


use DaveLiddament\StaticAnalyserAnalyser\Core\Common\LineNumber;
use DaveLiddament\StaticAnalyserAnalyser\Core\ExepctedResultsFileParser\ExpectedResult;
use DaveLiddament\StaticAnalyserAnalyser\Core\ExepctedResultsFileParser\ExpectedResultsFileParser;
use PHPUnit\Framework\TestCase;

class ExpectedResultsFileParserTest extends TestCase
{
    /**
     * @var ExpectedResultsFileParser
     */
    private $expectedResultsFileParser;


    protected function setUp(): void
    {
        $this->expectedResultsFileParser = new ExpectedResultsFileParser();
    }


    public function dataProvider(): array
    {
        return [
            [
                "singleIssue.code",
                [
                    new ExpectedResult(ExpectedResult::ISSUE, new LineNumber(5)),
                ],
            ],
            [
                "singleOK.code",
                [
                    new ExpectedResult(ExpectedResult::OK, new LineNumber(8)),
                ],
            ],
            [
                "singleOptional.code",
                [
                    new ExpectedResult(ExpectedResult::OPTIONAL, new LineNumber(3)),
                ],
            ],
            [
                "multipleIssues.code",
                [
                    new ExpectedResult(ExpectedResult::OPTIONAL, new LineNumber(5)),
                    new ExpectedResult(ExpectedResult::ISSUE, new LineNumber(7)),
                    new ExpectedResult(ExpectedResult::ISSUE, new LineNumber(10)),
                    new ExpectedResult(ExpectedResult::OK, new LineNumber(12)),
                ],
            ],

        ];
    }

    /**
     * @dataProvider  dataProvider
     *
     * @param ExpectedResult[] $expectedResults
     */
    public function testExpectedResults(string $fileName, array $expectedResults): void
    {
        $fullFileName = __DIR__ . "/resources/$fileName";
        $fileContents = file_get_contents($fullFileName);
        $actualResults = $this->expectedResultsFileParser->getExpectedResults($fileContents);
        $this->assertEquals(count($expectedResults), count($actualResults));
        foreach($expectedResults as $index => $expectedResult) {
            $actualResult = $actualResults[$index];
            $this->assertEquals($expectedResult, $actualResult);
        }
    }

}
