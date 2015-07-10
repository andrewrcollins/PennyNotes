<?php

/**
 * This file is part of the penny-notes/penny-notes package.
 *
 * (c) Andrew Collins <andrew@dripsandcastle.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 **/

namespace PennyNotes\PennyNotes;

/**
 * CreditRatingRandomSelector.
 *
 * Select random credit rating from credit ratings.
 *
 * @author Andrew Collins
 **/
class CreditRatingRandomSelector implements CreditRatingSelector
{
    /**
     * @var array
     **/
    private $creditRatings;

    /**
     * @param $creditRatings
     **/
    public function __construct($creditRatings)
    {
        // set credit ratings
        $this->creditRatings = $creditRatings;
    }

    /**
     * @return string
     **/
    public function getCreditRating()
    {
        // get random credit rating index from credit ratings
        $index = array_rand($this->creditRatings);

        // return random credit rating from credit ratings
        return $this->creditRatings[$index];
    }
}
