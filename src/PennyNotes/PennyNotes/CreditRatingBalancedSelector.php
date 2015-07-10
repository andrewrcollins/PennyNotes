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
 * CreditRatingBalancedSelector.
 *
 * @author Andrew Collins
 **/
class CreditRatingBalancedSelector implements CreditRatingSelector
{
    /**
     * @var array
     **/
    private $creditRatingAllocation;

    /**
     * @var PortfolioRepository
     **/
    private $portfolioRepository;

    /**
     * @var Portfolio
     **/
    private $portfolio;

    /**
     * @param $creditRatingAllocation
     * @param PortfolioRepository $portfolioRepository
     * @param Portfolio           $portfolio
     **/
    public function __construct($creditRatingAllocation, $portfolioRepository, $portfolio)
    {
        // set credit rating allocation
        $this->creditRatingAllocation = $creditRatingAllocation;

        // set portfolio repository
        $this->portfolioRepository = $portfolioRepository;

        // set portfolio
        $this->portfolio = $portfolio;
    }

    /**
     * @return string
     **/
    public function getCreditRating()
    {
        // get portfolio credit ratings
        $creditRatings = $this->portfolioRepository->getCreditRatings($this->portfolio);

        $totalCreditRatings = 0;

        foreach ($creditRatings as $creditRating => $count) {
            $totalCreditRatings += $count;
        }

        $delta = array(
                  'AA' => 0,
                  'A' => 0,
                  'B' => 0,
                  'C' => 0,
                  'D' => 0,
                  'E' => 0,
                  'HR' => 0,
                );

        if ($totalCreditRatings === 0) {
            foreach ($creditRatings as $creditRating => $count) {
                $delta[$creditRating] = -$this->creditRatingAllocation[$creditRating];
            }
        } else {
            foreach ($creditRatings as $creditRating => $count) {
                $delta[$creditRating] = $count / $totalCreditRatings - $this->creditRatingAllocation[$creditRating];
            }
        }

        // remove zero allocations from consideration
        foreach ($this->creditRatingAllocation as $creditRating => $allocation) {
            if ($allocation === 0) {
                unset($delta[$creditRating]);
            }
        }

        // sort delta
        asort($delta);

        // get delta keys
        $delta = array_keys($delta);

        // get credit rating with lowest delta
        $creditRating = $delta[0];

        // return credit rating
        return $creditRating;
    }
}
