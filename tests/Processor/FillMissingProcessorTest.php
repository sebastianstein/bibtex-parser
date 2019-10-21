<?php


namespace RenanBr\BibTexParser\Test\Processor;

use PHPUnit\Framework\TestCase;
use RenanBr\BibTexParser\Processor\FillMissingProcessor;

class FillMissingProcessorTest extends TestCase
{
    public function testWithMissingFields()
    {
        $processor = new FillMissingProcessor([
            'description' => 'this entry has no description',
        ]);

        $entry = $processor([
            'title' => 'foo',
        ]);

        $this->assertSame(
            'this entry has no description',
            $entry['description']
        );
    }

    public function testWithoutMissingFields()
    {
        $processor = new FillMissingProcessor([
            'description' => 'this entry has no description',
        ]);

        $entry = $processor([
            'title'       => 'foo',
            'description' => 'bar',
        ]);

        $this->assertSame(
            'bar',
            $entry['description']
        );
    }
}
