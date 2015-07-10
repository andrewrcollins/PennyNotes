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

use Doctrine\ORM\EntityRepository;
use DeepCopy\DeepCopy;
use DeepCopy\Filter\Doctrine\DoctrineCollectionFilter;
use DeepCopy\Matcher\PropertyTypeMatcher;

/**
 * PortfolioRepository.
 *
 * @author Andrew Collins
 **/
class PortfolioRepository extends EntityRepository
{
    /**
     * Copy portfolio.
     *
     * @param Portfolio $portfolio
     *
     * @see https://github.com/myclabs/DeepCopy
     **/
    public function copyPortfolio($portfolio)
    {
        // instantiate DeepCopy
        $deepCopy = new DeepCopy();

        // https://github.com/myclabs/DeepCopy#doctrinecollectionfilter
        $deepCopy->addFilter(new DoctrineCollectionFilter(), new PropertyTypeMatcher('Doctrine\Common\Collections\Collection'));

        // perform copy
        $copiedPortfolio = $deepCopy->copy($portfolio);

        // persist copied portfolio
        $this->getEntityManager()->persist($copiedPortfolio);

        $this->getEntityManager()->flush();

        // return copied portfolio
        return $copiedPortfolio;
    }

    /**
     * Get portfolio credit ratings.
     *
     * @param Portfolio $portfolio
     **/
    public function getCreditRatings($portfolio)
    {
        // portfolio credit ratings
        $creditRatings = array(
                  'AA' => 0,
                  'A' => 0,
                  'B' => 0,
                  'C' => 0,
                  'D' => 0,
                  'E' => 0,
                  'HR' => 0,
                );

        // construct query
        $query = $this->getEntityManager()->createQuery('

            SELECT
                COUNT(l.creditRating) AS total,
                l.creditRating
            FROM
                Loan l
            WHERE
                l.portfolio = :portfolio_id
            GROUP BY
                l.creditRating

        ');

        // set query parameter
        $query->setParameter('portfolio_id', $portfolio->getId());

        // execute query
        $rows = $query->getArrayResult();

        // consolidate portfolio credit ratings
        foreach ($rows as $row) {
            $creditRatings[$row['creditRating']] = $row['total'];
        }

        // return portfolio credit ratings
        return $creditRatings;
    }
}
