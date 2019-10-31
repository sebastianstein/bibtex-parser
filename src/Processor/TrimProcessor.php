<?php

/*
 * This file is part of the BibTex Parser.
 *
 * (c) Florent DESPIERRES <florent@despierres.pro>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RenanBr\BibTexParser\Processor;

class TrimProcessor
{
    /**
     * @param array $entry
     *
     * @return array
     */
    public function __invoke(array $entry)
    {
        return array_map(function ($row) {
            if (is_array($row)) {
                return $this->__invoke($row);
            }

            if (is_string($row)) {
                return \trim($row);
            }

            return $row;
        }, $entry);
    }
}
