<?php

declare(strict_types=1);


namespace DaveLiddament\StaticAnalyserAnalyser\Test\Core\ExpectedResultsParser;


use DaveLiddament\StaticAnalyserAnalyser\Core\Common\LineNumber;
use DaveLiddament\StaticAnalyserAnalyser\Core\ExepctedResultsFileParser\internal\FileLineParser;
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
        $this->markerFileParser = new MarkerFileParser(new FileLineParser());
    }


    public function dataProvider(): array
    {
        return [
            [
                "description.code",
                [
                    new Marker(Marker::DESCRIPTION, new LineNumber(3), "This is a description"),
                ],
            ],
            [
                "singleIssue.code",
                [
                    new Marker(Marker::ISSUE, new LineNumber(5), null),
                ],
            ],
            [
                "singleOK.code",
                [
                    new Marker(Marker::OK, new LineNumber(8), null),
                ],
            ],
            [
                "singleOptional.code",
                [
                    new Marker(Marker::OPTIONAL, new LineNumber(3), null),
                ],
            ],
            [
                "multipleIssues.code",
                [
                    new Marker(Marker::OPTIONAL, new LineNumber(5), null),
                    new Marker(Marker::ISSUE, new LineNumber(7), null),
                    new Marker(Marker::ISSUE, new LineNumber(10), null),
                    new Marker(Marker::OK, new LineNumber(12), null),
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
