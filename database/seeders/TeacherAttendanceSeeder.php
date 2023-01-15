<?php

namespace Database\Seeders;

use App\Models\Staff;
use App\Models\Session;
use Carbon\CarbonPeriod;
use Illuminate\Database\Seeder;
use App\Models\TeacherAttendance;

class TeacherAttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $session = Session::latest('id')->first();
        $dates = CarbonPeriod::create('2021-01-01', '2022-12-31');

        $teachers = Staff::where('designation', 'teacher')->get();
        foreach ($teachers as $teacher) {
            foreach ($dates as $date) {
                TeacherAttendance::create([
                    'teacher_id'    =>  $teacher->id,
                    'session_id'    =>  $session->id,
                    'date'          =>  $date->format('Y-m-d'),
                    'status'        =>  array_rand([0, 1]),
                ]);
            }
        }
    }
}
