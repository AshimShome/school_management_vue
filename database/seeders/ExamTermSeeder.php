<?php

namespace Database\Seeders;

use App\Models\ExamTerm;
use Illuminate\Database\Seeder;

class ExamTermSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ExamTerm::factory(3)->create();

        // Section Inserting
        $sections = [
            ['name' => 'First Term', 'note' => 'This is notes'],
            ['name' => 'Mid Term', 'note' => 'This is notes'],
            ['name' => 'Final Term', 'note' => 'This is notes']
        ];

        foreach ($sections as $section) {
            ExamTerm::create($section);
        }
    }
}
