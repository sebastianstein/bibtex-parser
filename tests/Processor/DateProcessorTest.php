<?php

namespace RenanBr\BibTexParser\Test\Processor;

use DateTime;
use DateTimeZone;
use Exception;
use PHPUnit\Framework\TestCase;
use RenanBr\BibTexParser\Processor\DateProcessor;

class DateProcessorTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testDateYearAndMonth()
    {
        $processor = new DateProcessor();
        $entry = $processor([
            'month' => '1~oct',
            'year' => '2000',
        ]);
        $this->assertEquals('2000', $entry['year']);
        $this->assertEquals('1~oct', $entry['month']);
        /** @var DateTime $dateTime */
        $dateTime = $entry['_date'];
        $this->assertEquals('2000-01-10T00:00:00+00:00', $dateTime->format(DateTime::ATOM));
        $this->assertEquals(new DateTimeZone('UTC'), $dateTime->getTimezone());
    }

    /**
     * @throws Exception
     */
    public function testMissingDayInMonth()
    {
        $processor = new DateProcessor();
        $entry = $processor(['month' => 'Jul', 'year' => '2000']);
        $this->assertEquals('Jul', $entry['month']);
        $this->assertEquals('2000', $entry['year']);
        $this->assertFalse(array_key_exists('_date', $entry));
    }

    /**
     * @throws Exception
     */
    public function testMissingMonthInMonth()
    {
        $processor = new DateProcessor();
        $entry = $processor(['month' => '05', 'year' => '2000']);
        $this->assertEquals('05', $entry['month']);
        $this->assertEquals('2000', $entry['year']);
        $this->assertFalse(array_key_exists('_date', $entry));
    }

    /**
     * @throws Exception
     */
    public function testDateSemiYear()
    {
        $processor = new DateProcessor();
        $entry = $processor(['month' => '1~jan', 'year' => '98']);
        $this->assertEquals('1~jan', $entry['month']);
        $this->assertEquals('98', $entry['year']);
        /** @var DateTime $dateTime */
        $dateTime = $entry['_date'];
        $this->assertEquals('1998-01-01T00:00:00+00:00', $dateTime->format(DateTime::ATOM));
        $this->assertEquals(new DateTimeZone('UTC'), $dateTime->getTimezone());
    }

    /**
     * @throws Exception
     */
    public function testDateInvalid()
    {
        $processor = new DateProcessor();
        $entry = $processor(['month' => 'foo', 'year' => 'bar']);
        $this->assertEquals('foo', $entry['month']);
        $this->assertEquals('bar', $entry['year']);
        $this->assertFalse(array_key_exists('_date', $entry));
    }

    /**
     * @throws Exception
     */
    public function testDateMissingYear()
    {
        $processor = new DateProcessor();
        $entry = $processor(['month' => '1~jan']);
        $this->assertEquals('1~jan', $entry['month']);
        $this->assertFalse(array_key_exists('_date', $entry));
    }

    /**
     * @throws Exception
     */
    public function testDateMissingMonth()
    {
        $processor = new DateProcessor();
        $entry = $processor(['year' => '2000']);
        $this->assertEquals('2000', $entry['year']);
        $this->assertFalse(array_key_exists('_date', $entry));
    }

    /**
     * @throws Exception
     */
    public function testDateMissingAll()
    {
        $processor = new DateProcessor();
        $entry = $processor([]);
        $this->assertFalse(array_key_exists('_date', $entry));
    }

    /**
     * @throws Exception
     */
    public function testDateAlreadyExist()
    {
        $processor = new DateProcessor();
        $entry = $processor(['_date' => 'I do exist']);
        $this->assertEquals('I do exist', $entry['_date']);
    }

}