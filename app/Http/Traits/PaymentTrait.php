<?php

namespace App\Http\Traits;

use App\Models\Fee;
use App\Models\Transaction;

trait PaymentTrait
{
    /**
     * Update userplan information.
     *
     * @param Int $fee_id
     * @return Object
     */
    public function feePay($fee_id)
    {
        $fee = Fee::with('type:id,name')->findOrFail($fee_id);
        $fee->update([
            'transaction_no' => $fee->transaction_no,
            'status' => 1,
            'pay_date' => date('Y-m-d')
        ]);

        return $fee;
    }

    /**
     * Create a new transaction instance.
     *
     * @param string $transaction_no
     * @param string $type
     * @param string $transaction_type
     * @param string $payment_type
     * @param int $student_id
     * @param int $plan_id
     *
     * @return boolean
     */
    public function createTransaction(
        string $transaction_no,
        int $student_id,
        int $amount,
        string $payment_type,
        string $type,
        string $transaction_type
    ) {
        Transaction::create([
            'transaction_no' => $transaction_no,
            'session_id' => currentSession(),
            'student_id' => $student_id ?? '',
            'income_type' => $type ?? '',
            'expense_type' => $type ?? '',
            'payment_type' => $payment_type ?? '',
            'amount' =>  $amount,
            'type' => $transaction_type == 'income' ? 'income' : 'expense',
        ]);
    }

    /**
     * Create a new expense transaction.
     *
     * @param string $transaction_no
     * @param string $type
     * @param string $transaction_type
     *
     * @return boolean
     */
    public function createExpenseTransaction(
        string $transaction_no,
        string $type,
        int $amount
    ) {
        Transaction::create([
            'transaction_no' => $transaction_no,
            'session_id' => currentSession(),
            'expense_type' => $type,
            'amount' =>  $amount,
            'type' => 'expense',
        ]);
    }

    /**
     * Create a new expense transaction.
     *
     * @param string $transaction_no
     * @param string $type
     * @param string $transaction_type
     *
     * @return boolean
     */
    public function createIncomeTransaction(
        $transaction_no,
        int $student_id,
        string $type,
        int $amount,
        $payment_type = 'Cash on'
    ) {
        Transaction::create([
            'transaction_no' => $transaction_no ?? uniqid(),
            'session_id' => currentSession(),
            'student_id' => $student_id,
            'income_type' => $type,
            'payment_type' => $payment_type,
            'amount' =>  $amount,
            'type' => 'income',
        ]);
    }


}
