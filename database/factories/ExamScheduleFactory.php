<?php

namespace Database\Factories;

use App\Models\ClassRoom;
use App\Models\Exam;
use App\Models\Classs;
use App\Models\Section;
use App\Models\Subject;
use App\Models\ExamSchedule;
use App\Models\Session;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExamScheduleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ExamSchedule::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'session_id'    =>   Session::latest('id')->first()->id,
            'exam_id'       =>   Exam::inRandomOrder()->first()->id,
            'room_id'       =>  ClassRoom::inRandomOrder()->first()->id,
            'class_id'      =>  Classs::inRandomOrder()->first()->id,
            'subject_id'    =>  Subject::inRandomOrder()->first()->id,
            'section_id'    =>  Section::inRandomOrder()->first()->id,
            'start_time'    =>  $this->faker->time(),
            'end_time'      =>  $this->faker->time(),
        ];
    }
}
