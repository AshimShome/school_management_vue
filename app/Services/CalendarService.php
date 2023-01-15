<?php

namespace App\Services;

use App\Lesson;
use App\Models\ClassRoutine;

class CalendarService
{
    public function generateCalendarData($weekDays,$lessons)
    {
        $calendarData = [];
        $timeRange = (new TimeService)->generateTimeRange(config('app.calendar.start_time'), config('app.calendar.end_time'));

        foreach ($timeRange as $time)
        {
            $timeText = $time['start'] . ' - ' . $time['end'];
            $calendarData[$timeText] = [];

            foreach ($weekDays as $index => $day)
            {
                $lesson = $lessons->where('weekday', $index)->where('start_time', $time['start'])->first();

                if ($lesson)
                {
                    array_push($calendarData[$timeText], [
                        'class_name'   => $lesson->classs->name,
                        'section'   => $lesson->section->name,
                        'subject'   => $lesson->subject->name,
                        'room_no' => $lesson->class_room->room_no,
                        'teacher_name' => $lesson->teacher->user->name,
                        'rowspan'      => $lesson->difference/30 ?? '',
                        'routine_id'      => $lesson->id,
                        'time' => $lesson->start_time . ' - ' . $lesson->end_time,
                    ]);
                }
                else if (!$lessons->where('weekday', $index)->where('start_time', '<', $time['start'])->where('end_time', '>=', $time['end'])->count()){
                    array_push($calendarData[$timeText], 1);
                }else{
                    array_push($calendarData[$timeText], 0);
                }
            }
        }

        return $calendarData;
    }
}
