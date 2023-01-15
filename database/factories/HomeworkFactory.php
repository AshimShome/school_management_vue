<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Staff;
use App\Models\Classs;
use App\Models\Section;
use App\Models\Session;
use App\Models\Subject;
use App\Models\StudentHomework;
use Illuminate\Database\Eloquent\Factories\Factory;

class HomeworkFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = StudentHomework::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $start = $this->faker->dateTimeBetween('next Monday', 'next Monday +7 days');
        $end = $this->faker->dateTimeBetween($start, $start->format('Y-m-d') . ' +2 days');
        return [
            'title' => $this->faker->sentence(),
            'teacher_id' => Staff::where('designation','teacher')->inRandomOrder()->first()->id,
            'session_id' => Session::latest('id')->first()->id,
            'class_id' => Classs::inRandomOrder()->first()->id,
            'section_id' => Section::inRandomOrder()->first()->id,
            'subject_id' => Subject::inRandomOrder()->first()->id,
            'start_date' => $start,
            'end_date' => $end,
            'description' => $this->faker->paragraph(),
        ];
    }
}
