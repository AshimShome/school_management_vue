<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Exam;
use App\Models\ExamSchedule;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExamScheduleRequest;
use App\Http\Resources\Exam\ExamScheduleResource;

class ExamScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Exam $exam)
    {
        $exam_schedules = $exam->schedules->load('exam:id,name', 'subject:id,name', 'section:id,name', 'classs:id,name', 'room:id,room_no')->groupBy('class_id');
        return response()->json($exam_schedules);
        // return ExamScheduleResource::collection($exam->schedules->load('exam', 'subject', 'section', 'classs', 'room'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExamScheduleRequest $request)
    {
        $data = $request->only(['exam_id', 'room_id', 'class_id', 'subject_id', 'section_id', 'exam_date', 'start_time', 'end_time']);
        $data['session_id'] = adminSetting()->default_session_id;

        ExamSchedule::create($data);

        return responseSuccess('', '', 'Exam Schedule Create Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ExamSchedule  $examSchedule
     * @return \Illuminate\Http\Response
     */
    public function show(ExamSchedule $schedule)
    {
        return new ExamScheduleResource($schedule->load('exam'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ExamSchedule  $examSchedule
     * @return \Illuminate\Http\Response
     */
    public function update(ExamScheduleRequest $request, ExamSchedule $schedule)
    {
        $data = $request->only(['exam_id', 'room_id', 'class_id', 'subject_id', 'section_id', 'exam_date', 'start_time', 'end_time']);
        $schedule->update($data);

        return responseSuccess('', '', 'Exam Schedule Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ExamSchedule  $examSchedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExamSchedule $schedule)
    {
        dd(1);
        $schedule->delete();

        return responseSuccess('schedule', null, 'Exam schedule delete successfully');
    }
}
