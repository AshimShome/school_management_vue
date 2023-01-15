<?php

namespace Database\Factories;

use App\Models\Exam;
use App\Models\ExamTerm;
use App\Models\Session;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExamFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Exam::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            // 'name'          =>  $this->faker->name(),
            // 'term_id'       =>  ExamTerm::inRandomOrder()->first()->id,
            // 'session_id'    =>  Session::inRandomOrder()->first()->id,
            // 'note'          =>  $this->faker->paragraph()
        ];
    }
}
