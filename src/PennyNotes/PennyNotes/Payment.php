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
 * Payment.
 *
 * @Entity
 * @Table(name="payment")
 *
 * @author Andrew Collins
 **/
class Payment
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
    private $date;

    /**
     * @Column(type="integer")
     *
     * @var int
     **/
    private $period;

    /**
     * @Column(type="decimal", precision=20, scale=6)
     *
     * @var string
     **/
    private $principal;

    /**
     * @Column(type="decimal", precision=20, scale=6)
     *
     * @var string
     **/
    private $interest;

    /**
     * @Column(name="payment", type="decimal", precision=20, scale=6)
     *
     * @var string
     **/
    private $paymentTotal;

    /**
     * @Column(name="remaining_principal", type="decimal", precision=20, scale=6)
     *
     * @var string
     **/
    private $remainingPrincipalBalance;

    /**
     * @Column(name="principal_balance", type="decimal", precision=20, scale=6)
     *
     * @var string
     **/
    private $currentPrincipalBalance;

    /**
     * @Column(name="interest_balance", type="decimal", precision=20, scale=6)
     *
     * @var string
     **/
    private $currentInterestBalance;

    /**
     * @ManyToOne(targetEntity="Loan")
     **/
    private $loan;

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
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param $date
     **/
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return int
     **/
    public function getPeriod()
    {
        return $this->period;
    }

    /**
     * @param $period
     **/
    public function setPeriod($period)
    {
        $this->period = $period;
    }

    /**
     * @return string
     **/
    public function getPrincipal()
    {
        return $this->principal;
    }

    /**
     * @param $principal
     **/
    public function setPrincipal($principal)
    {
        $this->principal = $principal;
    }

    /**
     * @return string
     **/
    public function getInterest()
    {
        return $this->interest;
    }

    /**
     * @param $interest
     **/
    public function setInterest($interest)
    {
        $this->interest = $interest;
    }

    /**
     * @return string
     **/
    public function getPaymentTotal()
    {
        return $this->paymentTotal;
    }

    /**
     * @param $paymentTotal
     **/
    public function setPaymentTotal($paymentTotal)
    {
        $this->paymentTotal = $paymentTotal;
    }

    /**
     * @return string
     **/
    public function getRemainingPrincipalBalance()
    {
        return $this->remainingPrincipalBalance;
    }

    /**
     * @param $remainingPrincipalBalance
     **/
    public function setRemainingPrincipalBalance($remainingPrincipalBalance)
    {
        $this->remainingPrincipalBalance = $remainingPrincipalBalance;
    }

    /**
     * @return string
     **/
    public function getCurrentPrincipalBalance()
    {
        return $this->currentPrincipalBalance;
    }

    /**
     * @param $currentPrincipalBalance
     **/
    public function setCurrentPrincipalBalance($currentPrincipalBalance)
    {
        $this->currentPrincipalBalance = $currentPrincipalBalance;
    }

    /**
     * @return string
     **/
    public function getCurrentInterestBalance()
    {
        return $this->currentInterestBalance;
    }

    /**
     * @param $currentInterestBalance
     **/
    public function setCurrentInterestBalance($currentInterestBalance)
    {
        $this->currentInterestBalance = $currentInterestBalance;
    }

    /**
     * @param Loan $loan
     **/
    public function setLoan($loan)
    {
        $loan->addPayment($this);

        $this->loan = $loan;
    }
}
