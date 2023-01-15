<?php

namespace Database\Seeders;

use App\Models\Syllabus;
use Illuminate\Database\Seeder;

class SyllabusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Syllabus::factory(20)->create();
    }
}
