<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\ClassRoutine;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\CalendarService;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClassRoutineRequest;
use App\Http\Resources\Classs\ClassRoutineResource;

class ClassRoutineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getClassRoutine(Request $request)
    {
        $class_routines = ClassRoutine::with(['class_room:id,room_no','subject:id,name,code', 'section:id,name', 'classs:id,name','teacher' => function ($q){
            $q->select(['user_id','id']);
            $q->with('user:name,id');
        }])
            ->where('session_id', currentSession())
            ->where('class_id', $request->class_id)
            ->where('section_id',$request->section_id)
            ->oldest('start_time')
            ->get()
            ->groupBy(['weekday']);


        return $class_routines;
    }

    public function getClassRoutinePreview(Request $request, CalendarService $calendarService){
        $request->validate([
            'class_id' => ['required', 'exists:classses,id'],
            'section_id' => ['required', 'exists:sections,id'],
        ]);

        $routines = ClassRoutine::with(['class_room:id,room_no','subject:id,name,code', 'section:id,name', 'classs:id,name','teacher' => function ($q){
            $q->select(['user_id','id']);
            $q->with('user:name,id');
        }])
            ->where('session_id', currentSession())
            ->where('class_id', $request->class_id)
            ->where('section_id',$request->section_id)
            ->get();

        $weekDays     = ClassRoutine::WEEK_DAYS;
        $calendarData = $calendarService->generateCalendarData($weekDays,$routines);

        return response()->json([
            'weekDays'     => $weekDays,
            'calendarData' => $calendarData
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClassRoutineRequest $request)
    {
        $data = $request->all();
        $data['session_id'] = currentSession();
        $classRoutine = ClassRoutine::create($data);

        return responseSuccess('class_routine', $classRoutine, 'Class routine create successfully');
    }

    /**
     * Fetch the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ClassRoutine  $classRoutine
     * @return \Illuminate\Http\Response
     */
    public function show(ClassRoutine $classRoutine)
    {
        return $classRoutine;
        // $classRoutine->update($request->all());

        // return responseSuccess('class_routine', $classRoutine, 'Class routine update successfully');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ClassRoutine  $classRoutine
     * @return \Illuminate\Http\Response
     */
    public function update(ClassRoutineRequest $request, ClassRoutine $classRoutine)
    {
        $data = $request->all();
        $classRoutine->update($data);

        return responseSuccess('class_routine', $classRoutine, 'Class Routine Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ClassRoutine  $classRoutine
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClassRoutine $classRoutine)
    {
        $classRoutine->delete();

        return responseSuccess('', '', 'Class routine delete successfully');
    }
}
