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
 * Credit Rating Selector Factory.
 *
 * @author Andrew Collins
 **/
class CreditRatingSelectorFactory
{
    /**
     * Choose and create appropriate credit rating selector.
     *
     * @param $strategy
     * @param PortfolioRepository $portfolioRepository
     * @param Portfolio           $portfolio
     **/
    public static function create($strategy, $portfolioRepository, $portfolio)
    {
        // choose appropriate credit rating selector
        switch ($strategy) {
            case CreditRatingSelector::RANDOM:
                // all credit ratings
                $creditRatings = array('AA','A','B','C','D','E','HR');

                // use credit rating random selector
                $selector = new CreditRatingRandomSelector($creditRatings);
            break;
            case CreditRatingSelector::LOWER_RISK:
                // lower risk credit ratings
                $creditRatings = array('AA','A','B');

                // use credit rating random selector
                $selector = new CreditRatingRandomSelector($creditRatings);
            break;
            case CreditRatingSelector::MEDIUM_RISK:
                // medium risk credit ratings
                $creditRatings = array('B','C','D');

                // use credit rating random selector
                $selector = new CreditRatingRandomSelector($creditRatings);
            break;
            case CreditRatingSelector::HIGHER_RISK:
                // high risk credit ratings
                $creditRatings = array('D','E','HR');

                // use credit rating random selector
                $selector = new CreditRatingRandomSelector($creditRatings);
            break;
            case CreditRatingSelector::BALANCED_LOWER:
                // balanced lower risk credit rating allocation
                $creditRatingAllocation = array(
                  'AA' => 0.45, // 45%
                  'A' => 0.35, // 35%
                  'B' => 0.2, // 20%
                  'C' => 0, // 0%
                  'D' => 0, // 0%
                  'E' => 0, // 0%
                  'HR' => 0, // 0%
                );

                // use credit rating allocation and portfolio credit ratings
                $selector = new CreditRatingBalancedSelector($creditRatingAllocation, $portfolioRepository, $portfolio);
            break;
            case CreditRatingSelector::BALANCED_MEDIUM:
                // balanced medium risk credit rating allocation
                $creditRatingAllocation = array(
                  'AA' => 0.35, // 35%
                  'A' => 0.3, // 30%
                  'B' => 0.2, // 20%
                  'C' => 0.1, // 10%
                  'D' => 0.05, // 5%
                  'E' => 0, // 0%
                  'HR' => 0, // 0%
                );

                // use credit rating allocation and portfolio credit ratings
                $selector = new CreditRatingBalancedSelector($creditRatingAllocation, $portfolioRepository, $portfolio);
            break;
            case CreditRatingSelector::BALANCED_HIGHER:
                // balanced higher risk credit rating allocation
                $creditRatingAllocation = array(
                  'AA' => 0.25, // 25%
                  'A' => 0.2, // 20%
                  'B' => 0.2, // 20%
                  'C' => 0.15, // 15%
                  'D' => 0.1, // 10%
                  'E' => 0.05, // 5%
                  'HR' => 0.05, // 5%
                );

                // use credit rating allocation and portfolio credit ratings
                $selector = new CreditRatingBalancedSelector($creditRatingAllocation, $portfolioRepository, $portfolio);
            break;
        }

        // return credit rating selector
        return $selector;
    }
}
