<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Event::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->unique()->sentence();
        return [
            'title'     =>  $title,
            'slug'     =>  Str::slug($title),
            'date'     =>  $this->faker->date(),
            'starting_time'     =>  $this->faker->time(12),
            'ending_time'     =>  $this->faker->time(18),
            'venue'     =>  $this->faker->city,
            'description'     =>  $this->faker->paragraph(),
            'image'     =>  $this->faker->imageUrl(),
        ];
    }
}
