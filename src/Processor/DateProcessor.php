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


use DateTimeImmutable;
use Exception;

class DateProcessor
{
    use TagSearchTrait;

    /**
     * @param array $entry
     *
     * @return array
     * @throws Exception
     */
    public function __invoke(array $entry)
    {
        $yearTag = $this->tagSearch('year', array_keys($entry));
        $monthTag = $this->tagSearch('month', array_keys($entry));
        $day = null;
        $month = null;
        $year = null;
        if ($yearTag !== null && $monthTag !== null) {
            $year = $entry[$yearTag];
            $monthArray = explode('~', $entry[$monthTag]);
            if (count($monthArray) === 2) {
                list($day, $month) = $monthArray;
                $dateMonthNumber = date_parse($month);
                if (checkdate($dateMonthNumber['month'], $day, $year)) {
                    $entry['_date'] = new DateTimeImmutable(date('d/m/Y', strtotime($day . ' ' . $month . ' ' . $year)));
                }
            }
        }
        return $entry;
    }
}