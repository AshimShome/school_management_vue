<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClassRequest;
use App\Models\Classs;

class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return responseSuccess('classes', Classs::with('sections:id,name')->get(['id', 'name', 'slug', 'numeric']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ClassRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClassRequest $request)
    {
        $class = Classs::create($request->except(['sections']));
        $this->classSectionSave($class, $request->sections);

        return responseSuccess('', '', 'Class Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Classs $class)
    {
        return responseSuccess('sections', $class->sections);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ClassRequest  $request
     * @param  Classs  $class
     * @return \Illuminate\Http\Response
     */
    public function update(ClassRequest $request, Classs $class)
    {
        $class->update($request->except(['sections']));
        $this->classSectionSave($class, $request->sections);

        return responseSuccess('', '', 'Class Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Classs $class)
    {
        try {
            $class->delete();
            $class->sections()->delete();

            return responseSuccess('', '', 'Class Deleted Successfully');
        } catch (\Throwable $th) {
            return responseError($th->getMessage(), 403);
        }
    }

    /**
     * Class Section data create to storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    protected function classSectionSave($class, $sections)
    {
        $sectionsArray = [];
        foreach ($sections as $item) {
            array_push($sectionsArray, $item['id']);
        }

        if ($class->sections->count()) {
            $class->sections()->sync($sectionsArray);
        } else {
            $class->sections()->attach($sectionsArray);
        }

        return true;
    }

    public function getSectionsByClass(Classs $class)
    {
        return responseSuccess('sections', $class->sections);
    }
}
