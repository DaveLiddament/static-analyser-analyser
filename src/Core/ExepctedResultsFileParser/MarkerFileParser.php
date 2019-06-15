<?php

declare(strict_types=1);


namespace DaveLiddament\StaticAnalyserAnalyser\Core\ExepctedResultsFileParser;


use DaveLiddament\StaticAnalyserAnalyser\Core\Common\LineNumber;

class MarkerFileParser
{

    /**
     * Returns all the Markers found in a file.
     *
     * @return Marker[]
     */
    public function getMarkers(string $fileContents): array
    {
        $markers = [];

        $lines = explode(PHP_EOL, $fileContents);
        foreach($lines as $index => $line) {
            $lineNumber = $index + 1;

            foreach(Marker::VALID_TYPES as $type) {
                $searchTerm = "// $type";
                if (strpos($line, $searchTerm) !== false) {
                    $markers[] = new Marker($type, new LineNumber($lineNumber), null);
                }
            }
        }

        return $markers;
    }

}
