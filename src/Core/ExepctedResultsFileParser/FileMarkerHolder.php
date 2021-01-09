<?php

declare(strict_types=1);


namespace DaveLiddament\StaticAnalyserAnalyser\Core\ExepctedResultsFileParser;


use DaveLiddament\StaticAnalyserAnalyser\Core\Common\FileName;
use DaveLiddament\StaticAnalyserAnalyser\Core\Common\LineNumber;
use InvalidArgumentException;
use Webmozart\Assert\Assert;

/**
 * Holds all markers for a given File.
 *
 * Validates that markers are correct.
 *
 * - Only one description (this must have text)
 * - At least one OK or ISSUE marker
 */
class FileMarkerHolder
{
    private ?string $description = null;

    /**
     * @var Marker[]
     */
    private array $issues = [];

    /**
     * @var Marker[]
     */
    private array $ok = [];

    /**
     * @var Marker[]
     */
    private array $optional = [];

    /**
     * @param Marker[] $markers
     * @throws InvalidFileMarkers
     */
    public function __construct(FileName $fileName, iterable $markers)
    {
        foreach($markers as $marker) {
            switch($marker->getType()) {
                case Marker::DESCRIPTION:
                    $this->processDescription($marker, $fileName);
                    break;

                case Marker::OK:
                    $this->ok[] = $marker;
                    break;

                case Marker::ISSUE:
                    $this->issues[] = $marker;
                    break;

                case Marker::OPTIONAL:
                    $this->optional[] = $marker;
                    break;

                default:
                    throw new InvalidArgumentException("Unknown type {$marker->getType()}");
            }
        }

        if ($this->description === null) {
            throw InvalidFileMarkers::missingDescription($fileName);
        }

        $count = count($this->issues) + count($this->ok);

        if ($count === 0) {
            throw InvalidFileMarkers::noIssuesOrOk($fileName);
        }
    }

    /**
     * @return Marker[]
     */
    public function getIssues(): array
    {
        return $this->issues;
    }

    /**
     * @return Marker[]
     */
    public function getOks(): array
    {
        return $this->ok;
    }

    public function isIssueExpected(LineNumber $lineNumber): bool
    {
        foreach([$this->optional, $this->issues] as $markers) {
            foreach ($markers as $marker) {
                if ($marker->getLineNumber()->equals($lineNumber)) {
                    return true;
                }
            }
        }
        return false;
    }

    private function processDescription(Marker $marker, FileName $fileName): void
    {
        Assert::same(Marker::DESCRIPTION, $marker->getType());
        $description = $marker->getAdditionalInformation();

        if ($description === null) {
            throw InvalidFileMarkers::noDescriptionText($fileName);
        }
        if ($this->description !== null) {
            throw InvalidFileMarkers::duplicateDescriptions($fileName);
        }
        $this->description = $description;
    }

    public function getDescription(): string
    {
        Assert::notNull($this->description);
        return $this->description;
    }
}
