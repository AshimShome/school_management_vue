<?php

namespace Database\Seeders;

use App\Models\Exam;
use App\Models\Classs;
use App\Models\Session;
use App\Models\ExamMark;
use App\Models\Student;
use Illuminate\Database\Seeder;

class ExamMarkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sessions = Session::all();
        $classes = Classs::with(['sections', 'subjects'])->get();

        foreach ($sessions as $session) {
            foreach ($session->exams  as $exam) {
                foreach ($classes as $singleClass) {
                    $sections = $singleClass->sections;

                    foreach ($sections as $section) {
                        $students = $singleClass->students()->where('section_id', $section->id)->get();
                        foreach ($students as $student) {
                            foreach ($singleClass->subjects as $subject) {
                                ExamMark::create([
                                    'session_id'       =>  $session->id,
                                    'exam_id'           =>  $exam->id,
                                    'class_id'          =>  $singleClass->id,
                                    'subject_id'        =>  $subject->id,
                                    'section_id'        =>  $section->id,
                                    'roll_no'           =>  $student->roll_no,
                                    'mark'              =>  array_rand(range(25, 100)),
                                ]);
                            }
                        }
                    }
                }
            }
        }
    }
}
