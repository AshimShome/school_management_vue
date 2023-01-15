<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExamTermRequest;
use App\Http\Resources\Exam\ExamResource;
use App\Http\Resources\Exam\ExamTermResource;
use App\Models\ExamTerm;

class ExamTermController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $terms = ExamTerm::all();

        return ExamTermResource::collection($terms);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExamTermRequest $request)
    {
        $term = ExamTerm::create($request->all());

        return responseSuccess('term', $term, 'Term create successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ExamTerm  $examTerm
     * @return \Illuminate\Http\Response
     */
    public function show(ExamTerm $examTerm)
    {
        return new ExamTermResource($examTerm);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ExamTerm  $examTerm
     * @return \Illuminate\Http\Response
     */
    public function update(ExamTermRequest $request, ExamTerm $examTerm)
    {
        $examTerm->update($request->all());

        return responseSuccess('term', $examTerm, 'Term update successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ExamTerm  $examTerm
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExamTerm $examTerm)
    {
        $examTerm->delete();

        return responseSuccess('term', null, 'Term delete successfully!');
    }

    /**
     * Get Term Exams
     */
    public function getExamByTerm(ExamTerm $term)
    {
        return ExamResource::collection($term->exams);
    }

    public function fetchAllTerms()
    {
        $terms = ExamTerm::all(['id', 'name']);
        return responseSuccess('terms', $terms);
    }
}
