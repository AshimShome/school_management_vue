<?php

namespace Database\Factories;

use App\Models\Transaction;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'transaction_no' => uniqid(),
            'session_id' => \App\Models\Session::latest('id')->first()->id,
            'student_id' => \App\Models\Student::inRandomOrder()->value('id'),
            'income_type' => \App\Models\FeeType::inRandomOrder()->value('name'),
            'expense_type' => \App\Models\ExpenseType::inRandomOrder()->value('name'),
            'payment_type' => Arr::random(['Stripe', 'Razorpay', 'Paypal', 'Paytm', 'Bank', 'SSl Commerz']),
            'amount' => rand(10, 50),
            'type' => Arr::random(['income', 'expense']),
            'created_at'  => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
