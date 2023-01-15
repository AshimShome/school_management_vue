<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExamResultRuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $gpa_grades = [
            [
                'name'          =>  'A+',
                'gpa'           =>  5.0,
                'min_mark'      =>  80,
                'max_mark'      =>  100,
                'created_at'    =>  now(),
                'updated_at'     =>  now()
            ],
            [
                'name'          =>  'A',
                'gpa'           =>  4.0,
                'min_mark'      =>  70,
                'max_mark'      =>  79,
                'created_at'    =>  now(),
                'updated_at'     =>  now()
            ],
            [
                'name'          =>  'A-',
                'gpa'           =>  3.5,
                'min_mark'      =>  60,
                'max_mark'      =>  69,
                'created_at'    =>  now(),
                'updated_at'     =>  now()
            ],
            [
                'name'          =>  'B',
                'gpa'           =>  3.0,
                'min_mark'      =>  50,
                'max_mark'      =>  59,
                'created_at'    =>  now(),
                'updated_at'     =>  now()
            ],
            [
                'name'          =>  'C',
                'gpa'           =>  2.0,
                'min_mark'      =>  40,
                'max_mark'      =>  49,
                'created_at'    =>  now(),
                'updated_at'     =>  now()
            ],
            [
                'name'          =>  'D',
                'gpa'           =>  1.0,
                'min_mark'      =>  33,
                'max_mark'      =>  40,
                'created_at'    =>  now(),
                'updated_at'     =>  now()
            ],
            [
                'name'          =>  'F',
                'gpa'           =>  0.0,
                'min_mark'      =>  0,
                'max_mark'      =>  32,
                'created_at'    =>  now(),
                'updated_at'     =>  now()
            ],
        ];

        DB::table('exam_result_rules')->insert($gpa_grades);
    }
}
