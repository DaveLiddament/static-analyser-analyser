<?php

declare(strict_types=1);


namespace DaveLiddament\StaticAnalyserAnalyser\Core\ExepctedResultsFileParser\internal;


use DaveLiddament\StaticAnalyserAnalyser\Core\Common\LineNumber;
use DaveLiddament\StaticAnalyserAnalyser\Core\ExepctedResultsFileParser\Marker;

class FileLineParser
{
    private const START = '//';

    /**
     * Parse a single line in a file and return a marker if there is one.
     */
    public function parse(string $line, LineNumber $lineNumber): ?Marker
    {
        $startMarkerPosition = strpos($line, self::START);
        if ($startMarkerPosition === false) {
            return null;
        }

        // Search for each of the markers
        foreach (Marker::VALID_TYPES as $type) {
            $position = strpos($line, $type, $startMarkerPosition);
            if ($position !== false) {
                return $this->getMarker($line, $position, $type, $lineNumber);
            }
        }

        return null;
    }

    private function getMarker(string $line, int $position, string $type, $lineNumber): Marker
    {
        $removeBefore = $position + strlen($type);
        $remaining = substr($line, $removeBefore);
        $trimmed = trim($remaining);

        $additionalInformation = empty($trimmed) ? null : $trimmed;

        return new Marker($type, $lineNumber, $additionalInformation);
    }

}
