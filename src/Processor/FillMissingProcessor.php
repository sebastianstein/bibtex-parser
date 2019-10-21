<?php

namespace RenanBr\BibTexParser\Processor;

class FillMissingProcessor
{
    use TagCoverageTrait;

    protected $missingFields;

    public function __construct($missingFields)
    {
        $this->missingFields = $missingFields;

        $this->setTagCoverage(['author', 'editor']);
    }

    public function __invoke(array $entry)
    {
        foreach ($this->missingFields as $tag => $value) {
            if(!array_key_exists($tag, $entry)) {
                $entry[$tag] = $value;
            }
        }

        return $entry;
    }
}
