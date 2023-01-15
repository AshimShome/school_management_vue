<?php

namespace Database\Factories;

use App\Models\Classs;
use App\Models\Exam;
use App\Models\ExamMark;
use App\Models\ExamTerm;
use App\Models\Section;
use App\Models\Session;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExamMarkFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ExamMark::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'session_id'        =>  Session::latest('id')->first()->id,
            'exam_id'           =>  Exam::inRandomOrder()->first()->id,
            'class_id'          =>  Classs::inRandomOrder()->first()->id,
            'section_id'        =>  Section::inRandomOrder()->first()->id,
            'subject_id'        =>  Subject::inRandomOrder()->first()->id,
            'roll_no'           =>  mt_rand(1, 100),
            'mark'              =>  mt_rand(0, 100),
            'note'              =>  $this->faker->sentence(10),
        ];
    }
}
