<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Guardian;
use App\Models\Session;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class GuardianFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Guardian::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = User::create([
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->email,
            'password' => bcrypt('password'),
            'role' => 'guardian',
            'email_verified_at' => now(),
        ]);
        $user->assignRole('Guardian');

        return [
            'user_id'               => $user->id,
            'session_id'            => Session::latest('id')->first()->id,
            'phone'                 => $this->faker->phoneNumber,
            'occupation'            => $this->faker->name(),
        ];
    }
}
