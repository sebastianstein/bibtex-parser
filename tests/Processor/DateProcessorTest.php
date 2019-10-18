<?php


namespace RenanBr\BibTexParser\Test\Processor;


use DateTime;
use DateTimeInterface;
use DateTimeZone;
use PHPUnit\Framework\TestCase;
use RenanBr\BibTexParser\Processor\DateProcessor;

class DateProcessorTest extends TestCase
{
    public function testDateYearAndMonth()
    {
        $processor = new DateProcessor();
        $entry = $processor([
            'month' => '"1~" # jan',
            'year' => '2000',
        ]);
        $this->assertEquals('2000', $entry['year']);
        $this->assertEquals('1~jan', $entry['month']);
        /** @var DateTime $dateTime */
        $dateTime = $entry['_date'];
        $this->assertEquals('2000-01-01T00:00:00+00:00', $dateTime->format(DateTimeInterface::ATOM));
        $this->assertEquals(new DateTimeZone('UTC'), $dateTime->getTimezone());
    }

    public function testDateYearAndMonthInverted()
    {
        $processor = new DateProcessor();
        $entry = $processor([
            'month' => 'Jul # "~4"',
            'year' => '2000',
        ]);
        $this->assertEquals('2000', $entry['year']);
        $this->assertEquals('4~Jul', $entry['month']);
        /** @var DateTime $dateTime */
        $dateTime = $entry['_date'];
        $this->assertEquals('2000-07-04T00:00:00+00:00', $dateTime->format(DateTimeInterface::ATOM));
        $this->assertEquals(new DateTimeZone('UTC'), $dateTime->getTimezone());
    }
}