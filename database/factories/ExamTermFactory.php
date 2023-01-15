<?php

namespace Database\Factories;

use App\Models\ExamTerm;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExamTermFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ExamTerm::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'      =>  uniqid('EXAM_TERM_'),
            'note'      =>  $this->faker->paragraph()
        ];
    }
}
