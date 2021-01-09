<?php

declare(strict_types=1);


namespace DaveLiddament\StaticAnalyserAnalyser\Test\Core\ExpectedResultsFileParser;


use DaveLiddament\StaticAnalyserAnalyser\Core\Common\FileName;
use DaveLiddament\StaticAnalyserAnalyser\Core\Common\LineNumber;
use DaveLiddament\StaticAnalyserAnalyser\Core\ExepctedResultsFileParser\FileMarkerHolder;
use DaveLiddament\StaticAnalyserAnalyser\Core\ExepctedResultsFileParser\InvalidFileMarkers;
use DaveLiddament\StaticAnalyserAnalyser\Core\ExepctedResultsFileParser\Marker;
use DaveLiddament\StaticAnalyserAnalyser\Test\Builders\MarkerBuilder;
use PHPUnit\Framework\TestCase;

class FileMarkerHolderTest extends TestCase
{
    const DESCRIPTION = "Info";

    /**
     * @var FileName
     */
    private $fileName;

    protected function setUp(): void
    {
        $this->fileName = new FileName("foo.php");
    }

    public function testDescriptionAndOk(): void
    {
        $descriptionMarker = MarkerBuilder::description()->additionalInformation(self::DESCRIPTION)->build();
        $okMarker = MarkerBuilder::ok()->lineNumber(5)->build();

        $fileMarkerHolder = new FileMarkerHolder($this->fileName, [
            $descriptionMarker,
            $okMarker,
        ]);

        $this->assertSame(self::DESCRIPTION, $fileMarkerHolder->getDescription());
        $this->assertSame([$okMarker], $fileMarkerHolder->getOks());
    }

    public function testDescriptionAndIssue(): void
    {
        $descriptionMarker = MarkerBuilder::description()->additionalInformation(self::DESCRIPTION)->build();
        $issueMarker = MarkerBuilder::issue()->lineNumber(5)->build();

        $fileMarkerHolder = new FileMarkerHolder($this->fileName, [
            $descriptionMarker,
            $issueMarker,
        ]);

        $this->assertSame(self::DESCRIPTION, $fileMarkerHolder->getDescription());
        $this->assertSame([$issueMarker], $fileMarkerHolder->getIssues());
    }


    public function testNoDescriptionText(): void
    {
        $descriptionMarker = MarkerBuilder::description()->build();
        $okMarker = MarkerBuilder::ok()->lineNumber(5)->build();

        $this->expectException(InvalidFileMarkers::class);
        new FileMarkerHolder($this->fileName, [
            $descriptionMarker,
            $okMarker,
        ]);
    }

    public function testDuplicateDescriptionsText(): void
    {
        $descriptionMarker = MarkerBuilder::description()->additionalInformation(self::DESCRIPTION)->build();
        $descriptionMarker2 = MarkerBuilder::description()->additionalInformation(self::DESCRIPTION)->build();
        $okMarker = MarkerBuilder::ok()->lineNumber(5)->build();

        $this->expectException(InvalidFileMarkers::class);
        new FileMarkerHolder($this->fileName, [
            $descriptionMarker,
            $descriptionMarker2,
            $okMarker,
        ]);
    }

    public function testNoDescription(): void
    {
        $okMarker = MarkerBuilder::ok()->lineNumber(5)->build();
        $this->expectException(InvalidFileMarkers::class);
        new FileMarkerHolder($this->fileName, [
            $okMarker,
        ]);
    }

    public function testNoOkOrIssue(): void
    {
        $issueMarker = MarkerBuilder::issue()->lineNumber(5)->build();
        $this->expectException(InvalidFileMarkers::class);
        new FileMarkerHolder($this->fileName, [
            $issueMarker,
        ]);
    }


}
