<?php

namespace App\Http\Controllers\Api\Student;

use App\Models\Staff;
use App\Models\Section;
use App\Models\Session;
use Illuminate\Http\Request;
use App\Models\StudentHomework;
use App\Http\Controllers\Controller;
use App\Http\Requests\HomeworkRequest;
use App\Http\Resources\Student\HomeworkResource;

class HomeworkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $homeworks = StudentHomework::with('teacher.user:id,name','subject:id,name')->whereSessionId(currentSession())
        ->whereClassId($request->class_id)
        ->whereSectionId($request->section_id)
        ->latest('start_date')
        ->get();

        return response()->json($homeworks);

        // return HomeworkResource::collection($homeworks);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getTeachers()
    {
        $teachers = Staff::with('user:id,name')->whereDesignation('teacher')->get();
        return responseSuccess('teachers', $teachers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HomeworkRequest $request)
    {
        $data = $request->all();
        $data['session_id'] = currentSession();

        StudentHomework::create($data);

        return responseSuccess('', '', 'Homework Created Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StudentHomework  $homework
     * @return \Illuminate\Http\Response
     */
    public function show(StudentHomework $homework)
    {
        return new HomeworkResource($homework);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(HomeworkRequest $request, StudentHomework $homework)
    {
        $homework->update($request->all());

        return responseSuccess('', '', 'Homework Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(StudentHomework $homework)
    {
        $homework->delete();

        return responseSuccess('', '', 'Homework Deleted successfully!');
    }
}
