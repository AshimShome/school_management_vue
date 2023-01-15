<?php

namespace App\Http\Controllers\Api\Staff;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Staff;
use Illuminate\Http\Request;
use App\Models\TeacherAttendance;
use App\Http\Controllers\Controller;
use App\Http\Requests\TeacherAttendanceRequest;

class TeacherAttendanceController extends Controller
{
    /**
     * Get students by class.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getTeachers(Request $request)
    {
        $session_id = currentSession();

        $request->validate(['date' => ['required', 'date']]);

        $teachers = Staff::select(['id', 'user_id', 'department_id',])
            ->with('user:id,name,image')
            ->where('designation', 'teacher')
            ->get();

        $attendances = $this->getTeacherAttendancesByDate($request, $teachers, $session_id);

        $data = [];
        $last7date_attendace = [];
        foreach ($teachers as $teacher) {
            $teacher->attendances = $this->getAttaendance($teacher, $attendances);
            $last7date_attendace[] = $this->lastSevenDaysAttendances($teacher, $session_id);
            $data[] = $teacher;
        }

        return [
            'teachers' => $data,
            'lastdays_attendace' => $last7date_attendace,
        ];
    }

    /**
     * Save Teacher Attendance
     */
    public function saveTeacherAttendance(TeacherAttendanceRequest $request)
    {
        foreach ($request->teacher_data as $row) {
            $attendance = TeacherAttendance::where('teacher_id', $row['teacher_id'])
                ->where('date', $row['date'])
                ->first();

            $data = $row;
            $data['session_id'] = currentSession();

            if ($attendance) {
                $attendance->update($data);
            } else {
                TeacherAttendance::create($data);
            }
        }

        return responseSuccess(null, null, 'Teacher attendance update successfully!');
    }

    /**
     * Get Teacher Attendance By date
     */
    public function getTeacherAttendancesByDate(Request $request, $teachers, $session_id)
    {
        $teachers_id = $teachers->map(fn ($teacher) => $teacher->id);

        return  TeacherAttendance::whereIn('teacher_id', $teachers_id)
            ->where('date', $request->date)
            ->where('session_id', $session_id)
            ->get(['teacher_id', 'date', 'status'])
            ->groupBy('teacher_id');
    }

    /**
     *
     * Get Single Student Attendance Status
     */
    function getAttaendance($teacher, $attendences)
    {
        $attendence = [];
        $key = (string) $teacher->id;
        if (isset($attendences[$key])) {
            $attendence['entry'] = true;
            $attendence['status'] = $attendences[$key][0]['status'] == 1 ? true : false;
        } else {
            $attendence['entry'] = false;
            $attendence['status'] = false;
        }
        return $attendence;
    }

    /**
     *
     *Get Single Student Attendance Status
     */
    function lastSevenDaysAttendances($teacher, $session_id)
    {
        return TeacherAttendance::where('teacher_id', $teacher->id)
            ->where('session_id', $session_id)
            ->where('date', '>=', Carbon::now()->subDays(7)->format('Y-m-d'))
            ->take(7)
            ->get(['date', 'status'])
            ->transform(fn ($attendance) => [
                'date' => $attendance->date,
                'status' => $attendance->status,
            ]);
    }
}
