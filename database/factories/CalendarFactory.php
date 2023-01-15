<?php

namespace Database\Factories;

use App\Models\Calendar;
use App\Models\Session;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class CalendarFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Calendar::class;

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
            'event_name' => Arr::random(['Test Event', 'Test Event 2', 'Test Event 3']),
            'session_id' =>  Session::latest('id')->first()->id,
            'start_date' => $start,
            'end_date' =>  $end,
        ];
    }
}
