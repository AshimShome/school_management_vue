<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Exam;
use Illuminate\Http\Request;
use App\Http\Requests\ExamRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\Exam\ExamResource;
use App\Http\Resources\Exam\UpcomingExamResource;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->has('search') && request()->search != null) {
            $search = request('search');
            $exams = Exam::where('session_id', adminSetting()->default_session_id)->where('name', 'LIKE', "%$search%")->oldest('id')->paginate(10);
        } else {
            $exams = Exam::where('session_id', adminSetting()->default_session_id)->oldest('id')->paginate(10);
        }

        return ExamResource::collection($exams);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExamRequest $request)
    {
        $exam = Exam::create([
            'name' => $request->name,
            'note' => $request->note,
            'session_id' => adminSetting()->default_session_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return responseSuccess('exam', $exam, 'Exam Created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function show(Exam $exam)
    {
        return new ExamResource($exam->load('term'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function update(ExamRequest $request, Exam $exam)
    {
        $exam->update([
            'name' => $request->name,
            'note' => $request->note,
            'session_id' => adminSetting()->default_session_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return responseSuccess('exam', $exam, 'Exam update successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function destroy(Exam $exam)
    {
        $exam->delete();

        return responseSuccess('exam', null, 'Exam delete successfully!');
    }

    /**
     * Get exams by session & terms
     */
    public function getExamBySessionAndTerm(Request $request)
    {
        $exams = Exam::where('session_id', adminSetting()->default_session_id)->get();

        return ExamResource::collection($exams);
    }

    public function getExamBySession()
    {
        $exams = Exam::where('session_id', adminSetting()->default_session_id)->get();

        return ExamResource::collection($exams);
    }

    public function getExamsList()
    {
        $exams = Exam::where('session_id', adminSetting()->default_session_id)
            ->get(['id', 'name']);

        return $exams;
    }

    public function getUpcomingExams()
    {
        $exams = Exam::where('session_id', adminSetting()->default_session_id)->get();
        return UpcomingExamResource::collection($exams);
    }
}
