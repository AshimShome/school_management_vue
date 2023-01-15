<?php

namespace Database\Seeders;

use App\Models\Classs;
use App\Models\Section;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Section Inserting
        $sections = [
            ['name' => 'A', 'slug' => 'a', 'capacity' => '20'],
            ['name' => 'B', 'slug' => 'b', 'capacity' => '20'],
            ['name' => 'C', 'slug' => 'c', 'capacity' => '20']
        ];

        foreach ($sections as $section) {
            Section::create($section);
        }

        // Class Section Inserting
        $class_sections = [
            ['class_id' => 1, 'section_id' => 1],
            ['class_id' => 1, 'section_id' => 2],
            ['class_id' => 1, 'section_id' => 3],

            ['class_id' => 2, 'section_id' => 1],
            ['class_id' => 2, 'section_id' => 2],
            ['class_id' => 2, 'section_id' => 3],

            ['class_id' => 3, 'section_id' => 1],
            ['class_id' => 3, 'section_id' => 2],
            ['class_id' => 3, 'section_id' => 3],

            ['class_id' => 4, 'section_id' => 1],
            ['class_id' => 4, 'section_id' => 2],
            ['class_id' => 4, 'section_id' => 3],

            ['class_id' => 5, 'section_id' => 1],
            ['class_id' => 5, 'section_id' => 2],
            ['class_id' => 5, 'section_id' => 3],
        ];

        foreach ($class_sections as $class_section) {
            DB::table('class_section')->insert($class_section);
        }
    }
}
