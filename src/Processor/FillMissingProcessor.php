<?php

/*
 * This file is part of the BibTex Parser.
 *
 * (c) Renan de Lima Barbosa <renandelima@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RenanBr\BibTexParser\Processor;

class FillMissingProcessor
{
    use TagSearchTrait;

    protected $missingFields;

    public function __construct($missingFields)
    {
        $this->missingFields = $missingFields;
    }

    public function __invoke(array $entry)
    {
        $tags = array_keys($entry);

        foreach ($this->missingFields as $tag => $value) {
            if(!$this->tagSearch($tag, $tags)) {
                $entry[$tag] = $value;
            }
        }

        return $entry;
    }
}
