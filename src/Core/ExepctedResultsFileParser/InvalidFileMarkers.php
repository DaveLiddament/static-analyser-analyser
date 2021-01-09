<?php

declare(strict_types=1);


namespace DaveLiddament\StaticAnalyserAnalyser\Core\ExepctedResultsFileParser;


use DaveLiddament\StaticAnalyserAnalyser\Core\Common\FileName;
use Exception;

class InvalidFileMarkers extends Exception
{
    private FileName $fileName;

    public static function missingDescription(FileName $fileName): self
    {
        return new self("Missing description in file [{$fileName}]", $fileName);
    }

    public static function noIssuesOrOk(FileName $fileName): self
    {
        return new self("No OK or ISSUE markers in file [$fileName]", $fileName);
    }

    public static function noDescriptionText(FileName $fileName): self
    {
        return new self("Description field is missing comment in [$fileName]", $fileName);
    }

    public static function duplicateDescriptions(FileName $filedName): self
    {
        return new self("Duplicate descriptions in file [$filedName]", $filedName);
    }


    public function __construct(string $message, FileName $fileName)
    {
        parent::__construct($message);
        $this->fileName = $fileName;
    }

    public function getFileName(): FileName
    {
        return $this->fileName;
    }

}
