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

/**
 * LoanRepository.
 *
 * @author Andrew Collins
 **/
class LoanRepository extends EntityRepository
{
    public function originateLoan($loan)
    {
        // get loan origination date
        $originationDate = $loan->getOriginationDate();

        // get loan periods (months)
        $periods = $loan->getPeriods();

        // get loan annual interest rate
        $annualInterestRate = $loan->getInterestRate();

        // convert annual interest to daily modified interest rate
        $dailyInterestRate = bcdiv($annualInterestRate, 365);

        // get monthly payment total amount
        $paymentTotalAmount = SimpleFinance::bcpayment($annualInterestRate, $periods);

        // remaining principal balance
        $remainingPrincipalBalance = 25;
        $currentPrincipalBalance = 0;
        $currentInterestBalance = 0;

        // get first due date, one month after origination
        $paymentDueDate = clone $originationDate;
        $paymentDueDate->modify('+1 month');

        // get number of days between origination date and first due date
        $days = $originationDate->diff($paymentDueDate)->format('%a');

        // set payment period
        $period = 1;

        // generate loan payment scheudle
        while ($period <= $periods) {
            // get payment date
            $paymentDate = clone $paymentDueDate;

            // calculate monthly interest payment
            $interestAmount = bcmul($remainingPrincipalBalance, bcmul($dailyInterestRate, $days));
            // handle final catch-up payment differently
            if ($period === $periods) {
                $paymentTotalAmount = bcadd($remainingPrincipalBalance, $interestAmount);
            }

            // calculate monthly principal payment
            $principalAmount = bcsub($paymentTotalAmount, $interestAmount);

            // update remaining principal balance
            $remainingPrincipalBalance = bcsub($remainingPrincipalBalance, $principalAmount);

            // update current principal balance
            $currentPrincipalBalance = bcadd($currentPrincipalBalance, $principalAmount);

            // update current interest balance
            $currentInterestBalance = bcadd($currentInterestBalance, $interestAmount);

            // -----

            // create payment
            $payment = new Payment();

            $payment->setDate($paymentDate);
            $payment->setPeriod($period);
            $payment->setPrincipal($principalAmount);
            $payment->setInterest($interestAmount);
            $payment->setPaymentTotal($paymentTotalAmount);
            $payment->setRemainingPrincipalBalance($remainingPrincipalBalance);
            $payment->setCurrentPrincipalBalance($currentPrincipalBalance);
            $payment->setCurrentInterestBalance($currentInterestBalance);

            // set loan
            $payment->setLoan($loan);

            // persist payment
            $this->getEntityManager()->persist($payment);
            $this->getEntityManager()->flush();

            // -----

            // advance due date one month
            $paymentDueDate->modify('+1 month');

            // get number of days between current due date and next due date
            $days = $paymentDate->diff($paymentDueDate)->format('%a');

            // increment payment period
            ++$period;
        }
    }
}
