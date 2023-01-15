<?php

namespace Database\Seeders;

use App\Models\Exam;
use App\Models\Session;
use App\Models\ExamTerm;
use Illuminate\Support\Arr;
use Illuminate\Database\Seeder;

class ExamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Exam::create([
            'name'          =>  'First Term',
            'session_id'    =>  1,
            'note'    =>  'This is a note',
            'start_date'    =>  '2020-04-01',
            'end_date'    =>  '2020-04-25',
        ]);

        Exam::create([
            'name'          =>  'Second Term',
            'session_id'    =>  1,
            'note'    =>  'This is a note',
            'start_date'    =>  '2020-07-10',
            'end_date'    =>  '2020-07-30',
        ]);

        Exam::create([
            'name'          =>  'Final Term',
            'session_id'    =>  1,
            'note'    =>  'This is a note',
            'start_date'    =>  '2020-10-01',
            'end_date'    =>  '2020-10-25',
        ]);

        Exam::create([
            'name'          =>  'First Term',
            'session_id'    =>  2,
            'note'    =>  'This is a note',
            'start_date'    =>  '2021-04-01',
            'end_date'    =>  '2021-04-25',
        ]);

        Exam::create([
            'name'          =>  'Second Term',
            'session_id'    =>  2,
            'note'    =>  'This is a note',
            'start_date'    =>  '2021-07-10',
            'end_date'    =>  '2021-07-30',
        ]);

        Exam::create([
            'name'          =>  'Final Term',
            'session_id'    =>  2,
            'note'    =>  'This is a note',
            'start_date'    =>  '2021-10-01',
            'end_date'    =>  '2021-10-25',
        ]);
    }
}
