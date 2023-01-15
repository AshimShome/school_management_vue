<?php

namespace Database\Factories;

use App\Models\Expense;
use App\Models\Session;
use App\Models\ExpenseType;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExpenseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Expense::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'type_id' => ExpenseType::inRandomOrder()->value('id'),
            'session_id' => Session::latest('id')->first()->id,
            'amount' => rand(100, 1000),
            'transaction_no' => uniqid(),
        ];
    }
}
