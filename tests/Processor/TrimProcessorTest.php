<?php

/*
 * This file is part of the BibTex Parser.
 *
 * (c) Florent DESPIERRES <florent@despierres.pro>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RenanBr\BibTexParser\Test\Processor;

use PHPUnit\Framework\TestCase;
use RenanBr\BibTexParser\Processor\TrimProcessor;

class TrimProcessorTest extends TestCase
{
    /**
     * @param array $entry
     * @param array $expectedEntry
     *
     * @dataProvider entriesProvider
     */
    public function testProcessEntry($entry, $expectedEntry)
    {
        $processor = new TrimProcessor;
        $this->assertSame($expectedEntry, $processor($entry));
    }

    public function entriesProvider()
    {
        return [
            'basicEntry' =>
            [
                ['title' => '  Relativity: The Special and General Theory  ', 'citation-key' => '  einstein1916relativity'],
                ['title' => 'Relativity: The Special and General Theory', 'citation-key' => 'einstein1916relativity'],
            ],
            'EntryWithArray' =>
            [
                ['title' => '  Relativity...', 'keywords' => ['big data', '  data deluge', 'scientific method ']],
                ['title' => 'Relativity...', 'keywords' => ['big data', 'data deluge', 'scientific method']],
            ],
            'EntryWithOtherTypeUnHandle' =>
            [
                ['title' => '  Relativity...', 'year' => 2018],
                ['title' => 'Relativity...', 'year' => 2018],
            ],
        ];
    }
}
