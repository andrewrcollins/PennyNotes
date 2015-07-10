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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;

/**
 * Portfolio.
 *
 * @Entity(repositoryClass="PortfolioRepository")
 * @Table(name="portfolio")
 *
 * @author Andrew Collins
 **/
class Portfolio
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     *
     * @var int
     **/
    private $id;

    /**
     * @Column(type="string")
     *
     * @var string
     **/
    private $name;

    /**
     * @OneToMany(targetEntity="Loan", mappedBy="portfolio", cascade={"persist", "remove"})
     *
     * @var Loan[]
     **/
    private $loans;

    public function __construct()
    {
        // initialize loans
        $this->loans = new ArrayCollection();
    }

    /**
     * @return int
     **/
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     **/
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     **/
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param Loan $loan
     **/
    public function addLoan($loan)
    {
        $this->loans[] = $loan;
    }

    /**
     * @return Loan[]
     **/
    public function getLoans()
    {
        $criteria = Criteria::create()
            ->orderBy(array('originationDate' => Criteria::ASC));

        return $this->loans->matching($criteria);
    }
}
