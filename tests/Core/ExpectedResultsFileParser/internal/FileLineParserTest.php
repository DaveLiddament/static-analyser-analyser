<?php

declare(strict_types=1);


namespace DaveLiddament\StaticAnalyserAnalyser\Test\Core\ExpectedResultsFileParser\internal;


use DaveLiddament\StaticAnalyserAnalyser\Core\Common\LineNumber;
use DaveLiddament\StaticAnalyserAnalyser\Core\ExepctedResultsFileParser\internal\FileLineParser;
use DaveLiddament\StaticAnalyserAnalyser\Core\ExepctedResultsFileParser\Marker;
use PHPUnit\Framework\TestCase;

class FileLineParserTest extends TestCase
{
    private const LINE_NUMBER = 7;

    /**
     * @var FileLineParser
     */
    private $fileLineParser;

    protected function setUp(): void
    {
        $this->fileLineParser = new FileLineParser();
    }

    /**
     * @return array<int,array{string}>
     */
    public function noMarkerDataProvider(): array
    {
        return [
            ["function foo()"],
            ["function foo() // Some comment"],
            ["//"],
            ["  DESCRIPTION //"],
        ];
    }

    /**
     * @dataProvider noMarkerDataProvider
     */
    public function testNoMarkerFound(string $line): void
    {
        $result = $this->fileLineParser->parse($line, new LineNumber(self::LINE_NUMBER));
        $this->assertNull($result);
    }


    /**
     * @return array<int,array{string,Marker}>
     */
    public function markerDataProvider(): array
    {
        // Has to go here a setup not called before dataProviders
        $lineNumber = new LineNumber(self::LINE_NUMBER);

        return [
            [
                "//DESCRIPTION",
                new Marker(Marker::DESCRIPTION, $lineNumber, null),
            ],
            [
                "// DESCRIPTION",
                new Marker(Marker::DESCRIPTION, $lineNumber, null),
            ],
            [
                "//     DESCRIPTION",
                new Marker(Marker::DESCRIPTION, $lineNumber, null),
            ],
            [
                "   //     DESCRIPTION",
                new Marker(Marker::DESCRIPTION, $lineNumber, null),
            ],
            [
                "   //     DESCRIPTION some text",
                new Marker(Marker::DESCRIPTION, $lineNumber, "some text"),
            ],
            [
                "//DESCRIPTIONhello",
                new Marker(Marker::DESCRIPTION, $lineNumber, "hello"),
            ],
        ];
    }

    /**
     * @dataProvider markerDataProvider
     */
    public function testMarkerFound(string $line, Marker $expectedMarker): void
    {
        $result = $this->fileLineParser->parse($line, new LineNumber(self::LINE_NUMBER));
        $this->assertEquals($expectedMarker, $result);
    }
}

