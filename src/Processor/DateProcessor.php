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


use DateTime;

class DateProcessor
{
    use TagCoverageTrait;

    /**
     * @param array $entry
     *
     * @return array
     */
    public function __invoke(array $entry)
    {
        $covered = $this->getCoveredTags(array_keys($entry));
        $day = null;
        $month = null;
        $year = null;
        foreach ($covered as $tag) {
            if ($tag === 'month') {
                $monthArray = explode('#', $entry[$tag]);
                if (strpos($monthArray[0], '~')) {
                    $day = $this->getDay(trim($monthArray[0]));
                    $month = trim($monthArray[1]);
                } else if (strpos($monthArray[1], '~')) {
                    $day = $this->getDay(trim($monthArray[1]));
                    $month = trim($monthArray[0]);
                }
            }
            if ($tag === 'year') {
                $year = $entry[$tag];
            }
        }
        $entry['month'] = $day . '~' . $month;
        $entry['_date'] = new DateTime(date('d/m/Y', strtotime($month . ' ' . $day . ' ' . $year)));
        return $entry;
    }

    private function getDay($day)
    {
        return str_replace(['"', '~'], '', $day);
    }
}