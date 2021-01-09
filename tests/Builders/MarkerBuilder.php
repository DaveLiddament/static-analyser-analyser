<?php

declare(strict_types=1);


namespace DaveLiddament\StaticAnalyserAnalyser\Test\Builders;


use DaveLiddament\StaticAnalyserAnalyser\Core\Common\LineNumber;
use DaveLiddament\StaticAnalyserAnalyser\Core\ExepctedResultsFileParser\Marker;

class MarkerBuilder
{

    /**
     * @var string
     */
    private $type;
    /**
     * @var int
     */
    private $lineNumber;

    /**
     * @var null|string
     */
    private $additionalInformation;

    public static function ok(): self
    {
        return new self(Marker::OK);
    }

    public static function issue(): self
    {
        return new self(Marker::ISSUE);
    }

    public static function description(): self
    {
        return new self(Marker::DESCRIPTION);
    }


    public static function optional(): self
    {
        return new self(Marker::OPTIONAL);
    }

    public function __construct(string $type)
    {
        $this->type = $type;
        $this->lineNumber = 3;
        $this->additionalInformation = null;
    }

    public function lineNumber(int $lineNumber): self
    {
        $this->lineNumber = $lineNumber;

        return $this;
    }

    public function additionalInformation(string $additionalInformation): self
    {
        $this->additionalInformation = $additionalInformation;

        return $this;
    }

    public function build(): Marker
    {
        return new Marker($this->type, new LineNumber($this->lineNumber), $this->additionalInformation);
    }
}
