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
 * CreditRatingSelector.
 *
 * @author Andrew Collins
 **/
interface CreditRatingSelector
{
    const RANDOM = 'Random';
    const LOWER_RISK = 'Lower Risk';
    const MEDIUM_RISK = 'Medium Risk';
    const HIGHER_RISK = 'Higher Risk';
    const BALANCED_LOWER = 'Balanced Lower Risk';
    const BALANCED_MEDIUM = 'Balanced Medium Risk';
    const BALANCED_HIGHER = 'Balanced Higher Risk';

    public function getCreditRating();
}
