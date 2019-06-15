<?php

declare(strict_types=1);


namespace DaveLiddament\StaticAnalyserAnalyser\Core\ExepctedResultsFileParser;


use DaveLiddament\StaticAnalyserAnalyser\Core\Common\LineNumber;
use Webmozart\Assert\Assert;


/**
 * Represents a Marker of some sort (e.g. ISSUE expected here) for SSA.
 */
class Marker
{

    public const ISSUE = 'ISSUE';
    public const OK = 'OK';
    public const OPTIONAL = 'OPTIONAL';
    public const DESCRIPTION = 'DESCRIPTION';

    public const VALID_TYPES = [
        self::ISSUE,
        self::OK,
        self::OPTIONAL,
        self::DESCRIPTION,
    ];

    /**
     * @var string
     */
    private $type;

    /**
     * @var LineNumber
     */
    private $lineNumber;
    /**
     * @var string|null
     */
    private $additionalInformation;


    public function __construct(string $type, LineNumber $lineNumber, ?string $additionalInformation)
    {
        Assert::oneOf($type, self::VALID_TYPES, "Invalid type [$type]");
        $this->type = $type;
        $this->lineNumber = $lineNumber;
        $this->additionalInformation = $additionalInformation;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return LineNumber
     */
    public function getLineNumber(): LineNumber
    {
        return $this->lineNumber;
    }

    /**
     * @return string|null
     */
    public function getAdditionalInformation(): ?string
    {
        return $this->additionalInformation;
    }

}
