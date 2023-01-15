<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Syllabus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SyllabusRequest;
use Illuminate\Support\Facades\Storage;

class SyllabusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  SyllabusRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SyllabusRequest $request)
    {
        $data = $request->all();
        if ($request->hasFile('attachment') && $request->file('attachment')->isValid()) {
            $url = uploadFileToStorage($request->attachment, "/syllabus/attachment");
            $data['attachment'] = $url;
        }
        $data['exam_id'] = $request->exam_id;
        $data['class_id'] = $request->class_id;
        $data['subject_id'] = $request->subject_id;
        $data['session_id'] = adminSetting()->default_session_id;
        Syllabus::create($data);

        return responseSuccess('', '', 'Syllabus Created Successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SyllabusRequest $request, Syllabus $syllabus)
    {
        try {
            $data = $request->all();

            if ($request->hasFile('attachment') && $request->file('attachment')->isValid()) {
                deleteImage($syllabus->attachment);
                $url = uploadFileToStorage($request->attachment, "/syllabus/attachment");
                $data['attachment'] = $url;
            }

            $data['class_id'] = $request->class_id['id'];
            $data['exam_id'] = $request->exam_id['id'];
            $syllabus->update($data);

            return responseSuccess('syllabus', $syllabus->load('examTerm'), 'Syllabus Updated Successfully');
        } catch (\Throwable $th) {
            return responseError($th->getMessage(), 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Syllabus $syllabus)
    {
        try {
            $syllabus->delete();

            return responseSuccess('', '', 'Syllabus Deleted Successfully');
        } catch (\Throwable $th) {
            return responseError($th->getMessage(), 403);
        }
    }

    public function getSyllabusesByClass($class_id)
    {
        $syllabuses = Syllabus::where('session_id', currentSession())->with('examTerm:id,name')->where('class_id', $class_id)->get(['id', 'title', 'class_id', 'exam_id']);

        return responseSuccess('syllabuses', $syllabuses);
    }

    public function getTermsByClass($class_id)
    {
        $exams = Syllabus::where('session_id', currentSession())->select('exam_id')
            ->groupBy('exam_id')
            ->with('exam')
            ->where('class_id', $class_id)
            ->oldest('exam_id')
            ->get();

        return responseSuccess('exams', $exams);
    }

    public function getSyllabusDetails($class_id, $exam_id)
    {
        $syllabus_details = Syllabus::with('subject')
            ->where('class_id', $class_id)
            ->where('exam_id', $exam_id)
            ->get()
            ->transform(fn ($syllabus) => [
                'id' => $syllabus->id,
                'subject_name' => $syllabus->subject->name,
                'attachment' => $syllabus->attachment
            ]);

        return response()->json(['syllabus_details' => $syllabus_details], 200);
    }

    public function downloadAttachment(Request $request)
    {
        $syllabus = Syllabus::findOrFail($request->syllabus_id);
        $fileExt = explode(".", $syllabus->attachment)[1];
        $myFile = $syllabus->attachment;
        $headers = ["Content-Type: application/$fileExt"];
        $newName =  uniqid() . '.' . $fileExt;

        return Storage::download($myFile, $newName, $headers);
    }
}
