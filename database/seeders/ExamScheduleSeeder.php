<?php

namespace Database\Seeders;

use App\Models\Exam;
use App\Models\Classs;
use App\Models\Session;
use Carbon\CarbonPeriod;
use App\Models\ClassRoom;
use App\Models\ExamSchedule;
use Illuminate\Database\Seeder;

class ExamScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sessions = Session::all();
        $classRooms = ClassRoom::pluck('id')->all();
        $classes = Classs::with(['sections', 'subjects'])->get();

        $times = [
            ['start' => '09:00', 'end' => '10:00'],
            ['start' => '10:00', 'end' => '11:00'],
            ['start' => '11:00', 'end' => '12:00'],
            ['start' => '12:00', 'end' => '13:00'],
            ['start' => '13:00', 'end' => '14:00'],
            ['start' => '14:00', 'end' => '15:00'],
            ['start' => '15:00', 'end' => '16:00'],
            ['start' => '16:00', 'end' => '17:00'],
        ];

        $period = CarbonPeriod::create('2022-01-01', '3 days', '2022-12-31');
        $dates = [];
        foreach ($period as $date) {
            $dates[] = $date->format('Y-m-d');
        }

        foreach ($sessions as $session) {
            foreach ($session->exams as $exam) {
                foreach ($classes as $singleClass) {
                    foreach ($singleClass->sections as $section) {
                        foreach ($singleClass->subjects as $subject) {
                            $time = $times[array_rand($times)];
                            ExamSchedule::create([
                                'session_id'        =>  $session->id,
                                'exam_id'           =>  $exam->id,
                                'room_id'           =>  $classRooms[array_rand($classRooms)],
                                'class_id'          =>  $singleClass->id,
                                'subject_id'        =>  $subject->id,
                                'section_id'        =>  $section->id,
                                'exam_date'         =>  $dates[array_rand($dates)],
                                'start_time'        =>  $time['start'],
                                'end_time'          =>  $time['end'],
                            ]);
                        }
                    }
                }
            }
        }
    }
}
