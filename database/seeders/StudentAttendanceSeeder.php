<?php

namespace Database\Seeders;

use App\Models\Session;
use App\Models\Student;
use App\Models\StudentAttendance;
use Carbon\CarbonPeriod;
use Illuminate\Database\Seeder;

class StudentAttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $session = Session::latest('id')->first();
        $dates = CarbonPeriod::create('2022-01-01', '2022-12-31');

        $students = Student::where('session_id', $session->id)->get();
        foreach ($students as $student) {
            foreach ($dates as $date) {
                StudentAttendance::create([
                    'student_id'    =>  $student->id,
                    'session_id'    =>  $session->id,
                    'class_id'      =>  $student->class_id,
                    'section_id'    =>  $student->section_id,
                    'date'          =>  $date->format('Y-m-d'),
                    'status'        =>  array_rand([0, 1]),
                ]);
            }
        }
    }
}
