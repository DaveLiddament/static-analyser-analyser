<?php

declare(strict_types=1);


namespace DaveLiddament\StaticAnalyserAnalyser\Core\ExepctedResultsFileParser;


use DaveLiddament\StaticAnalyserAnalyser\Core\Common\LineNumber;
use DaveLiddament\StaticAnalyserAnalyser\Core\ExepctedResultsFileParser\internal\FileLineParser;

class MarkerFileParser
{

    /**
     * @var FileLineParser
     */
    private $fileLineParser;

    public function __construct(FileLineParser $fileLineParser)
    {
        $this->fileLineParser = $fileLineParser;
    }

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
            $lineNumber = new LineNumber($index + 1);

            $marker = $this->fileLineParser->parse($line, $lineNumber);
            if ($marker) {
                $markers[] = $marker;
            }
        }

        return $markers;
    }

}
