<?php

namespace App\Traits;

use App\Models\ExamResultRule;

trait Results
{
    /**
     * Formate Student Results
     */
    public function formatStudentsResultData($students, $subjects)
    {
        $result_rules = ExamResultRule::orderBy('id', 'ASC')->get();

        $data = [];
        foreach ($students as $student) {
            $marks = $student->marks->groupBy('subject_id');
            $gpa = [];
            foreach ($subjects as $subject) {
                $key = (string) $subject->id;
                if (isset($marks[$key])) {
                    $gpa[$key] = $this->getGpa($marks[$key][0]['mark'], $result_rules);
                } else {
                    $gpa[$key] = ['pass' => false, 'results' => 'N/A', 'entry' => false];
                }
            }
            $student->subjects = $gpa;
            $student->final_results = $this->getFinalResult($gpa);
            $data[] = $student;
        }

        return $data;
    }


    /***
     * Get Final Results
     */
    public function getFinalResult($results)
    {
        $status = true;
        $data = ['pass' => false, 'gpa' => 0];
        foreach ($results as $result) {
            if ($result['pass'] == false) {
                $status = false;
                break;
            }
        }

        if ($status) {
            $data['gpa'] = sprintf("%0.2f", (collect($results)->avg('results.point')));
            $data['pass'] = true;
        } else {
            $data['pass'] = false;
            $data['gpa'] = 0.00;
        }

        return $data;
    }

    /**
     * Get gpa
     */
    public function getGpa($average_mark, $result_rules)
    {
        $result = [];
        foreach ($result_rules as $rule) {
            $min = $rule->min_mark;
            $max = $rule->max_mark;
            if ($min <= $average_mark && $max >= $average_mark) {
                if ($rule->name == 'F') {
                    $result['pass'] = false;
                    $result['entry'] = true;
                    $result['results']['point'] = 0;
                    $result['results']['grade'] = 'F';
                } else {
                    $result['pass'] = true;
                    $result['entry'] = true;
                    $result['results']['point'] = $rule->gpa;
                    $result['results']['grade'] = $rule->name;
                }
                break;
            }
        }

        return $result;
    }
}
