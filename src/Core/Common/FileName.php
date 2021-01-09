<?php

declare(strict_types=1);


namespace DaveLiddament\StaticAnalyserAnalyser\Core\Common;


/**
 * Represents a filename
 */
class FileName
{

    /**
     * @var string
     */
    private $fileName;

    public function __construct(string $fileName)
    {
        $this->fileName = $fileName;
    }

    public function getFileName(): string
    {
        return $this->fileName;
    }

    public function __toString(): string
    {
        return $this->getFileName();
    }
}
