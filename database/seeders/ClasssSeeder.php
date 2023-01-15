<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Classs;

class ClasssSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $classes = [
            ['name' => 'One', 'slug' => 'one', 'numeric' => '1'],
            ['name' => 'Two', 'slug' => 'two', 'numeric' => '2'],
            ['name' => 'Three', 'slug' => 'three', 'numeric' => '3'],
            ['name' => 'Four', 'slug' => 'four','numeric' => '4' ],
            ['name' => 'Five', 'slug' => 'five','numeric' => '5' ],
        ];

        foreach ($classes as $class) {
            Classs::create($class);
        }
    }
}
