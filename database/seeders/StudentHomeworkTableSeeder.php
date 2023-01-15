<?php

namespace Database\Seeders;

use App\Models\StudentHomework;
use Illuminate\Database\Seeder;

class StudentHomeworkTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StudentHomework::factory()->count(50)->create();
    }
}
