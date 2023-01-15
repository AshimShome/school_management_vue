<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubjectRequest;
use App\Models\Classs;
use App\Models\Subject;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Classs::with('subjects')->get();
        return responseSuccess('subjects', Subject::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return responseSuccess('classes', Classs::all(['id', 'name']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SubjectRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubjectRequest $request)
    {
        try {
            $data = $request->all();
            $data['class_id'] = $request->class_id['id'];

            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $url = uploadFileToPublic($request->image, 'subjects');
                $data['image'] =  $url;
            }

            $subject = Subject::create($data);

            return responseSuccess('subject', $subject, 'Subject Created Successfully');
        } catch (\Throwable $th) {
            return responseError($th->getMessage(), 403);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function classSubjects($class_id)
    {
        $subjects = Subject::whereClassId($class_id)->get();
        return responseSuccess('subjects', $subjects);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  SubjectRequest  $request
     * @param  Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function update(SubjectRequest $request, Subject $subject)
    {
        try {
            $data = $request->all();
            $data['class_id'] = $request->class_id['id'];

            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                deleteImage($subject->image);
                $url = uploadFileToPublic($request->image, 'subjects');
                $data['image'] =  $url;
            }

            $subject->update($data);

            return responseSuccess('subject', $subject, 'Subject Updated Successfully');
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
    public function destroy(Subject $subject)
    {
        try {
            $subject->delete();

            return responseSuccess('', '', 'Subject Deleted Successfully');
        } catch (\Throwable $th) {
            return responseError($th->getMessage(), 403);
        }
    }
}
