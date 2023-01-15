<?php

namespace Database\Factories;

use App\Models\Exam;
use App\Models\Classs;
use App\Models\Session;
use App\Models\Subject;
use App\Models\Syllabus;
use Illuminate\Database\Eloquent\Factories\Factory;

class SyllabusFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Syllabus::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'session_id' => Session::latest('id')->first()->id,
            'exam_id' => Exam::inRandomOrder()->value('id'),
            'class_id' => Classs::inRandomOrder()->value('id'),
            'subject_id' => Subject::inRandomOrder()->value('id'),
        ];
    }
}
