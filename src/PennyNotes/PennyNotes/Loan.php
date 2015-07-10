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
 * Loan.
 *
 * @Entity(repositoryClass="LoanRepository")
 * @Table(name="loan")
 *
 * @author Andrew Collins
 **/
class Loan
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
     * @Column(type="date")
     *
     * @var DateTime
     **/
    private $originationDate;

    /**
     * @Column(type="integer")
     *
     * @var int
     **/
    private $periods;

    /**
     * @Column(type="decimal", precision=20, scale=6)
     *
     * @var string
     **/
    private $interestRate;

    /**
     * @Column(type="string")
     *
     * @var string
     **/
    private $creditRating;

    /**
     * @ManyToOne(targetEntity="Portfolio")
     **/
    private $portfolio;

    /**
     * @OneToMany(targetEntity="Payment", mappedBy="loan", cascade={"persist", "remove"})
     *
     * @var Payment[]
     **/
    private $payments;

    public function __construct()
    {
        // initialize payments
        $this->payments = new ArrayCollection();
    }

    /**
     * @return int
     **/
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return DateTime
     **/
    public function getOriginationDate()
    {
        return $this->originationDate;
    }

    /**
     * @param $originationDate
     **/
    public function setOriginationDate($originationDate)
    {
        $this->originationDate = $originationDate;
    }

    /**
     * @return int
     **/
    public function getPeriods()
    {
        return $this->periods;
    }

    /**
     * @param $periods
     **/
    public function setPeriods($periods)
    {
        $this->periods = $periods;
    }

    /**
     * @return string
     **/
    public function getInterestRate()
    {
        return $this->interestRate;
    }

    /**
     * @param $interestRate
     **/
    public function setInterestRate($interestRate)
    {
        $this->interestRate = $interestRate;
    }

    /**
     * @return string
     **/
    public function getCreditRating()
    {
        return $this->creditRating;
    }

    /**
     * @param $creditRating
     **/
    public function setCreditRating($creditRating)
    {
        $this->creditRating = $creditRating;
    }

    /**
     * @param Portfolio $portfolio
     **/
    public function setPortfolio($portfolio)
    {
        $portfolio->addLoan($this);

        $this->portfolio = $portfolio;
    }

    /**
     * @param Payment $payment
     **/
    public function addPayment($payment)
    {
        $this->payments[] = $payment;
    }

    /**
     * @return Payment[]
     **/
    public function getPayments()
    {
        $criteria = Criteria::create()
            ->orderBy(array('date' => Criteria::ASC));

        return $this->payments->matching($criteria);
    }
}
