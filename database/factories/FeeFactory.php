<?php

namespace Database\Factories;

use App\Models\Classs;
use App\Models\Fee;
use App\Models\FeeType;
use App\Models\Section;
use App\Models\Session;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class FeeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Fee::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $student = Student::inRandomOrder()->first();
        return [
            'type_id' => FeeType::inRandomOrder()->value('id'),
            'session_id' => Session::latest('id')->first()->id,
            'class_id' => Classs::inRandomOrder()->value('id'),
            'section_id' => Section::inRandomOrder()->value('id'),
            'student_id' => $student->id,
            'parent_id' => $student->guardian->id,
            'amount' => rand(100, 1000),
            'due_date' => now()->addDays(rand(1, 200))->format('Y-m-d'),
            'status' => rand(0, 1),
        ];
    }
}
