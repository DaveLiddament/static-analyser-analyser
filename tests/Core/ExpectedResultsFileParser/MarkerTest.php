<?php

declare(strict_types=1);


namespace DaveLiddament\StaticAnalyserAnalyser\Test\Core\ExpectedResultsFileParser;


use DaveLiddament\StaticAnalyserAnalyser\Core\Common\LineNumber;
use DaveLiddament\StaticAnalyserAnalyser\Core\ExepctedResultsFileParser\Marker;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class MarkerTest extends TestCase
{

    /**
     * @return array<int,array{string}>
     */
    public function dataProvider(): array
    {
        return [
            [Marker::OK],
            [Marker::ISSUE],
            [Marker::OPTIONAL],
            [Marker::DESCRIPTION],
        ];
    }


    /**
     * @dataProvider dataProvider
     */
    public function testHappyPath(string $type): void
    {
        $lineNumber = new LineNumber(7);
        $marker = new Marker($type, $lineNumber, null);

        $this->assertSame($type, $marker->getType());
        $this->assertSame($lineNumber, $marker->getLineNumber());
    }

    public function testInvalidType(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Marker("rubbish", new LineNumber(1), null);
    }

    public function testAdditionalData(): void
    {
        $lineNumber = new LineNumber(7);
        $marker = new Marker(Marker::DESCRIPTION, $lineNumber, "Additional info");

        $this->assertSame( "Additional info", $marker->getAdditionalInformation());
    }
}
