<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExamResultRuleRequest;
use App\Http\Resources\Exam\ExamResultRuleResource;
use App\Models\ExamResultRule;
use Illuminate\Http\Request;

class ExamResultRuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $exam_result_rules = ExamResultRule::all();

        return ExamResultRuleResource::collection($exam_result_rules);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExamResultRuleRequest $request)
    {
        $exam_result_rule = ExamResultRule::create($request->all());

        return responseSuccess('exam_result_rule', $exam_result_rule, 'Exam result rule create successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ExamResultRule  $examResultRule
     * @return \Illuminate\Http\Response
     */
    public function show(ExamResultRule $examResultRule)
    {
        return new ExamResultRuleResource($examResultRule);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ExamResultRule  $examResultRule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExamResultRule $examResultRule)
    {
        $examResultRule->update($request->all());

        return responseSuccess('exam_result_rule', $examResultRule, 'Exam result rule update successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ExamResultRule  $examResultRule
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExamResultRule $examResultRule)
    {
        $examResultRule->delete();

        return responseSuccess('schedule', null, 'Exam result rule delete successfully');
    }
}
