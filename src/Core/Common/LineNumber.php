<?php

declare(strict_types=1);


namespace DaveLiddament\StaticAnalyserAnalyser\Core\Common;


class LineNumber
{
    /**
     * @var int
     */
    private $lineNumber;

    public function __construct(int $lineNumber)
    {
        $this->lineNumber = $lineNumber;
    }

    public function getLineNumber(): int
    {
        return $this->lineNumber;
    }


    public function equals(LineNumber $other): bool
    {
        return $this->lineNumber === $other->lineNumber;
    }

}
