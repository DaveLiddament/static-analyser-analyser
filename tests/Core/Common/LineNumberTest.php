<?php

declare(strict_types=1);


namespace DaveLiddament\StaticAnalyserAnalyser\Test\Core\Common;


use DaveLiddament\StaticAnalyserAnalyser\Core\Common\LineNumber;
use PHPUnit\Framework\TestCase;

class LineNumberTest extends TestCase
{

    public function testEquals(): void
    {
        $a = new LineNumber(3);
        $b = new LineNumber(3);
        $this->assertTrue($a->equals($b));
    }

    public function testNotEquals(): void
    {
        $a = new LineNumber(3);
        $b = new LineNumber(4);
        $this->assertFalse($a->equals($b));
    }

    public function testGetValue(): void
    {
        $lineNumber = new LineNumber(3);
        $this->assertSame(3, $lineNumber->getLineNumber());
    }
}
