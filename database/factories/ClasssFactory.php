<?php

namespace Database\Factories;

use App\Models\Classs;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClasssFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Classs::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(1),
            'slug' => Str::slug($this->faker->name(1)),
            'numeric' => rand(1,10)
        ];
    }
}
