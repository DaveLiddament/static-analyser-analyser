<?php

declare(strict_types=1);


namespace DaveLiddament\StaticAnalyserAnalyser\Test\Core\ExpectedResultsParser;


use DaveLiddament\StaticAnalyserAnalyser\Core\Common\LineNumber;
use DaveLiddament\StaticAnalyserAnalyser\Core\ExepctedResultsFileParser\Marker;
use DaveLiddament\StaticAnalyserAnalyser\Core\ExepctedResultsFileParser\MarkerFileParser;
use PHPUnit\Framework\TestCase;

class MarkerFileParserTest extends TestCase
{
    /**
     * @var MarkerFileParser
     */
    private $markerFileParser;


    protected function setUp(): void
    {
        $this->markerFileParser = new MarkerFileParser();
    }


    public function dataProvider(): array
    {
        return [
            [
                "singleIssue.code",
                [
                    new Marker(Marker::ISSUE, new LineNumber(5)),
                ],
            ],
            [
                "singleOK.code",
                [
                    new Marker(Marker::OK, new LineNumber(8)),
                ],
            ],
            [
                "singleOptional.code",
                [
                    new Marker(Marker::OPTIONAL, new LineNumber(3)),
                ],
            ],
            [
                "multipleIssues.code",
                [
                    new Marker(Marker::OPTIONAL, new LineNumber(5)),
                    new Marker(Marker::ISSUE, new LineNumber(7)),
                    new Marker(Marker::ISSUE, new LineNumber(10)),
                    new Marker(Marker::OK, new LineNumber(12)),
                ],
            ],

        ];
    }

    /**
     * @dataProvider  dataProvider
     *
     * @param Marker[] $expectedResults
     */
    public function testExpectedResults(string $fileName, array $expectedResults): void
    {
        $fullFileName = __DIR__ . "/resources/$fileName";
        $fileContents = file_get_contents($fullFileName);
        $actualResults = $this->markerFileParser->getMarkers($fileContents);
        $this->assertEquals(count($expectedResults), count($actualResults));
        foreach($expectedResults as $index => $expectedResult) {
            $actualResult = $actualResults[$index];
            $this->assertEquals($expectedResult, $actualResult);
        }
    }

}
