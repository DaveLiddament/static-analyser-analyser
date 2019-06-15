<?php

declare(strict_types=1);


namespace DaveLiddament\StaticAnalyserAnalyser\Test\Core\ExpectedResultsFileParser;


use DaveLiddament\StaticAnalyserAnalyser\Core\Common\LineNumber;
use DaveLiddament\StaticAnalyserAnalyser\Core\ExepctedResultsFileParser\ExpectedResult;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ExpectedResultTest extends TestCase
{

    public function dataProvider(): array
    {
        return [
            [ExpectedResult::OK],
            [ExpectedResult::ISSUE],
            [ExpectedResult::OPTIONAL],
        ];
    }


    /**
     * @dataProvider dataProvider
     */
    public function testHappyPath(string $type): void
    {
        $lineNumber = new LineNumber(7);
        $okExpectedResult = new ExpectedResult($type, $lineNumber);

        $this->assertSame($type, $okExpectedResult->getType());
        $this->assertSame($lineNumber, $okExpectedResult->getLineNumber());
    }

    public function testInvalidType(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new ExpectedResult("rubbish", new LineNumber(1));
    }
}
