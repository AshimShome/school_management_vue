<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\ClassRoom;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClassRoomRequest;
use App\Http\Requests\ClassRoomUpdateRequest;

class ClassRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return responseSuccess('classrooms', ClassRoom::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClassRoomRequest $request)
    {
        try {
            $classroom = ClassRoom::create($request->all());

            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $url = uploadFileToPublic($request->image, 'room');
                $classroom->update(['image' => $url]);
            }

            return responseSuccess('classroom', $classroom, 'Class Room Created Successfully');
        } catch (\Throwable $th) {
            return responseError($th->getMessage(), 403);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ClassRoomUpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ClassRoomUpdateRequest $request, ClassRoom $classroom)
    {
        try {
            $classroom->update($request->all());

            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                deleteImage($classroom->image);
                $url = uploadFileToPublic($request->image, 'room');
                $classroom->update(['image' => $url]);
            }

            return responseSuccess('classroom', $classroom, 'Class Room Updated Successfully');
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
    public function destroy(ClassRoom $classroom)
    {
        try {
            $classroom->delete();

            return responseSuccess('', '', 'Class Room Deleted Successfully');
        } catch (\Throwable $th) {
            return responseError($th->getMessage(), 403);
        }
    }
}
