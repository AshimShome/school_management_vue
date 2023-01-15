<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Staff;
use App\Models\Department;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Database\Seeders\DepartmentSeeder;
use Illuminate\Database\Eloquent\Factories\Factory;

class StaffFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Staff::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $role = Arr::random(['Teacher', 'Accountant', 'Guardian', 'Student']);
        $user = User::create([
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->email,
            'password' => bcrypt('password'),
            'role' => 'staff',
            'email_verified_at' => now(),
        ]);
        $user->assignRole($role);

        return [
            'user_id'           =>  $user->id,
            'department_id'     =>  Department::inRandomOrder()->first()->id,
            'designation'     =>  $this->faker->randomElement(['teacher', 'accountant']),
            'joining_date'     =>  $this->faker->date(),
            'phone'     =>  $this->faker->phoneNumber,
            'gender'     =>  $this->faker->randomElement(['male', 'female']),
            'religion'     =>  $this->faker->randomElement(['muslim', 'hindu', 'christian', 'buddha']),
            'bio'     =>  $this->faker->text(),
            'joining_letter'     =>  $this->faker->text(),
            'resume'     =>  $this->faker->text(),
        ];
    }
}
