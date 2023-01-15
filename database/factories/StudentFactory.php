<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Classs;
use App\Models\Guardian;
use App\Models\Section;
use App\Models\Session;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class StudentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Student::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $guardianUser = User::create([
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->email,
            'password' => bcrypt('password'),
            'role' => 'guardian',
            'email_verified_at' => now(),
        ]);
        $guardianUser->assignRole('Guardian');

        $guardian = Guardian::create([
            'user_id'               =>  $guardianUser->id,
            'session_id'            => Session::latest('id')->first()->id,
            'phone'                 => $this->faker->phoneNumber,
            'occupation'            => $this->faker->name()
        ]);

        $student = User::create([
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->email,
            'password' => bcrypt('password'),
            'role' => 'student',
            'email_verified_at' => now(),
        ]);
        $student->assignRole('Student');

        return [
            'user_id'       =>  $student->id,
            'parent_id'       =>  $guardian->id,
            'session_id'       =>  Session::latest('id')->first()->id,
            'class_id'       =>  Classs::inRandomOrder()->first()->id,
            'section_id'       =>  Section::inRandomOrder()->first()->id,
            'roll_no'       =>  1,
            'admission_date'    => $this->faker->date(),
            'gender'   =>  $this->faker->randomElement(['male', 'female']),
            'date_of_birth' =>  $this->faker->date(),
            'blood_group'   =>  $this->faker->randomElement(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']),
        ];
    }
}
