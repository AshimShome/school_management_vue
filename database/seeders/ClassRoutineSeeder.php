<?php

namespace Database\Seeders;

use App\Models\ClassRoom;
use App\Models\ClassRoutine;
use App\Models\Classs;
use App\Models\Session;
use App\Models\Staff;
use Illuminate\Database\Seeder;

class ClassRoutineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $session = Session::latest('id')->first();

        $routines = [
            [
                'id'         => 1,
                'session_id' => $session->id,
                'class_id'   => 1,
                'section_id'   => 1,
                'class_room_id'   => 1,
                'teacher_id' => 3,
                'subject_id' => 1,
                'weekday'    => 1,
                'start_time' => '10:00',
                'end_time'   => '12:00',
            ],
            [
                'id'         => 2,
                'session_id' => $session->id,
                'class_id'   => 1,
                'section_id'   => 1,
                'class_room_id'   => 2,
                'teacher_id' => 2,
                'subject_id' => 2,
                'weekday'    => 1,
                'start_time' => '12:00',
                'end_time'   => '14:00',
            ],
            [
                'id'         => 3,
                'session_id' => $session->id,
                'class_id'   => 1,
                'section_id'   => 1,
                'class_room_id'   => 3,
                'teacher_id' => 1,
                'subject_id' => 3,
                'weekday'    => 1,
                'start_time' => '14:00',
                'end_time'   => '16:00',
            ],
            [
                'id'         => 4,
                'session_id' => $session->id,
                'class_id'   => 1,
                'section_id'   => 1,
                'class_room_id'   => 4,
                'teacher_id' => 5,
                'subject_id' => 1,
                'weekday'    => 1,
                'start_time' => '14:00',
                'end_time'   => '16:00',
            ],
            [
                'id'         => 5,
                'session_id' => $session->id,
                'class_id'   => 1,
                'section_id'   => 1,
                'class_room_id'   => 1,
                'teacher_id' => 3,
                'subject_id' => 2,
                'weekday'    => 2,
                'start_time' => '08:00',
                'end_time'   => '10:00',
            ],
            [
                'id'         => 6,
                'session_id' => $session->id,
                'class_id'   => 1,
                'section_id'   => 1,
                'class_room_id'   => 2,
                'teacher_id' => 1,
                'subject_id' => 3,
                'weekday'    => 2,
                'start_time' => '10:00',
                'end_time'   => '12:00',
            ],
            [
                'id'         => 7,
                'session_id' => $session->id,
                'class_id'   => 1,
                'section_id'   => 1,
                'class_room_id'   => 3,
                'teacher_id' => 2,
                'subject_id' => 1,
                'weekday'    => 2,
                'start_time' => '12:00',
                'end_time'   => '14:00',
            ],
            [
                'id'         => 8,
                'session_id' => $session->id,
                'class_id'   => 1,
                'section_id'   => 1,
                'class_room_id'   => 4,
                'teacher_id' => 5,
                'subject_id' => 2,
                'weekday'    => 3,
                'start_time' => '10:00',
                'end_time'   => '12:00',
            ],
            [
                'id'         => 9,
                'session_id' => $session->id,
                'class_id'   => 1,
                'section_id'   => 1,
                'class_room_id'   => 1,
                'teacher_id' => 5,
                'subject_id' => 3,
                'weekday'    => 3,
                'start_time' => '12:00',
                'end_time'   => '14:00',
            ],
            [
                'id'         => 10,
                'session_id' => $session->id,
                'class_id'   => 1,
                'section_id'   => 1,
                'class_room_id'   => 1,
                'teacher_id' => 3,
                'subject_id' => 1,
                'weekday'    => 3,
                'start_time' => '14:00',
                'end_time'   => '16:00',
            ],
            [
                'id'         => 11,
                'session_id' => $session->id,
                'class_id'   => 1,
                'section_id'   => 1,
                'class_room_id'   => 2,
                'teacher_id' => 2,
                'subject_id' => 2,
                'weekday'    => 4,
                'start_time' => '10:00',
                'end_time'   => '12:00',
            ],
            [
                'id'         => 12,
                'session_id' => $session->id,
                'class_id'   => 1,
                'section_id'   => 1,
                'class_room_id'   => 3,
                'teacher_id' => 1,
                'subject_id' => 3,
                'weekday'    => 4,
                'start_time' => '12:00',
                'end_time'   => '14:00',
            ],
            [
                'id'         => 13,
                'session_id' => $session->id,
                'class_id'   => 1,
                'section_id'   => 1,
                'class_room_id'   => 2,
                'teacher_id' => 1,
                'subject_id' => 1,
                'weekday'    => 4,
                'start_time' => '14:00',
                'end_time'   => '16:00',
            ],
            [
                'id'         => 14,
                'session_id' => $session->id,
                'class_id'   => 1,
                'section_id'   => 1,
                'class_room_id'   => 2,
                'teacher_id' => 3,
                'subject_id' => 2,
                'weekday'    => 5,
                'start_time' => '08:00',
                'end_time'   => '10:00',
            ],
            [
                'id'         => 15,
                'session_id' => $session->id,
                'class_id'   => 1,
                'section_id'   => 1,
                'class_room_id'   => 4,
                'teacher_id' => 2,
                'subject_id' => 3,
                'weekday'    => 5,
                'start_time' => '10:00',
                'end_time'   => '12:00',
            ],
            [
                'id'         => 16,
                'session_id' => $session->id,
                'class_id'   => 1,
                'section_id'   => 1,
                'class_room_id'   => 1,
                'teacher_id' => 1,
                'subject_id' => 1,
                'weekday'    => 5,
                'start_time' => '12:00',
                'end_time'   => '14:00',
            ],
        ];

        ClassRoutine::insert($routines);


        // // shuffle($teachers);
        // // shuffle($classRooms);

        // foreach ($classes as $singleClass) {
        //     foreach ($days as $day) {
        //         ClassRoutine::create([
        //             'session_id'        =>  $session->id,
        //             'class_id'          =>  $singleClass->id,
        //             'section_id'        =>  1,
        //             'class_room_id'     =>  $classRooms[array_rand($classRooms)],
        //             'teacher_id'        =>  $teachers[array_rand($teachers)],
        //             'subject_id'        =>  1,
        //             'day'               =>  $day,
        //             'start_time'          =>  "10:00",
        //             'end_time'          =>  "11:00",
        //         ]);
        //         ClassRoutine::create([
        //             'session_id'        =>  $session->id,
        //             'class_id'          =>  $singleClass->id,
        //             'section_id'        =>  1,
        //             'class_room_id'     =>  $classRooms[array_rand($classRooms)],
        //             'teacher_id'        =>  $teachers[array_rand($teachers)],
        //             'subject_id'        =>  2,
        //             'day'               =>  $day,
        //             'start_time'          =>  "11:30",
        //             'end_time'          =>  "12:30",
        //         ]);
        //         ClassRoutine::create([
        //             'session_id'        =>  $session->id,
        //             'class_id'          =>  $singleClass->id,
        //             'section_id'        =>  1,
        //             'class_room_id'     =>  $classRooms[array_rand($classRooms)],
        //             'teacher_id'        =>  $teachers[array_rand($teachers)],
        //             'subject_id'        =>  3,
        //             'day'               =>  $day,
        //             'start_time'        =>  "14:00",
        //             'end_time'          =>  "15:30",
        //         ]);
        //     }
        // }
    }
}
