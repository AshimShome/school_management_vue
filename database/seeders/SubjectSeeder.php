<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subject;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Subject::factory(5)->create();

        $subjects = [
            [
                'class_id' => '1',
                'name' => 'Bangla',
                'code' => '101'
            ],
            [
                'class_id' => '1',
                'name' => 'English',
                'code' => '102'
            ],
            [
                'class_id' => '1',
                'name' => 'Math',
                'code' => '103'
            ],
            [
                'class_id' => '2',
                'name' => 'Bangla',
                'code' => '101'
            ],
            [
                'class_id' => '2',
                'name' => 'English',
                'code' => '102'
            ],
            [
                'class_id' => '2',
                'name' => 'Math',
                'code' => '103'
            ],
            [
                'class_id' => '3',
                'name' => 'Bangla',
                'code' => '101'
            ],
            [
                'class_id' => '3',
                'name' => 'English',
                'code' => '102'
            ],
            [
                'class_id' => '3',
                'name' => 'Math',
                'code' => '103'
            ],
            [
                'class_id' => '4',
                'name' => 'Bangla',
                'code' => '101'
            ],
            [
                'class_id' => '4',
                'name' => 'English',
                'code' => '102'
            ],
            [
                'class_id' => '4',
                'name' => 'Math',
                'code' => '103'
            ],
            [
                'class_id' => '5',
                'name' => 'Bangla',
                'code' => '101'
            ],
            [
                'class_id' => '5',
                'name' => 'English',
                'code' => '102'
            ],
            [
                'class_id' => '5',
                'name' => 'Math',
                'code' => '103'
            ],
        ];

        foreach ($subjects as $subject) {
            Subject::create($subject);
        }
    }
}
