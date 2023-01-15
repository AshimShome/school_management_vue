<?php

namespace App\Http\Controllers\Api\Staff;

use App\Models\User;
use App\Models\Staff;
use App\Traits\UploadAble;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendLoginCredentialMail;
use App\Http\Requests\CreateTeacherRequest;
use App\Http\Requests\UpdateTeacherRequest;
use App\Http\Resources\Staff\StaffResource;

class TeacherController extends Controller
{
    use UploadAble;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $staffs = Staff::where(['designation' => 'teacher'])->with('user')->paginate(10);

        if (request()->has('search') && request()->search != null) {
            $search = request('search');
            $staffs = Staff::where(['designation' => 'teacher'])->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'LIKE', "%$search%");
            })
                ->with('user', 'department')
                ->paginate(10);
        } else {
            $staffs = Staff::where(['designation' => 'teacher'])->with('user', 'department')->paginate(12);
        }


        return StaffResource::collection($staffs);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTeacherRequest $request)
    {
        // User info
        $user_data = $request->only('name', 'email', 'password');
        $user_data['role'] = 'staff';
        $user_data['password'] = bcrypt($request->password);
        $user = User::create($user_data);
        $user->assignRole('Teacher');

        // Teacher info
        $teacher_data = $request->only('department_id', 'joining_date', 'phone', 'gender');
        $teacher_data['user_id'] = $user->id;
        $teacher_data['session_id'] = currentSession();
        $teacher_data['designation'] = 'teacher';

        if ($request->hasFile('joining_letter')) {
            $teacher_data['joining_letter'] = $this->uploadOne($request->file('joining_letter'), 'joining_letters');
        }
        if ($request->hasFile('resume')) {
            $teacher_data['resume'] = $this->uploadOne($request->file('resume'), 'resumes');
        }

        $teacher = Staff::create($teacher_data);

        // Mail Send
        checkSetup() ? Mail::to($user->email)->send(new SendLoginCredentialMail($user, $request->password)) : '';

        return responseSuccess('teacher', $teacher, 'Teacher create successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function show(Staff $teacher)
    {
        //Need Improvements
        return new StaffResource($teacher->load('user', 'department'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTeacherRequest $request, Staff $teacher)
    {
        // User info
        $user = $teacher->user;
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        // Teacher info
        $teacher_data = $request->only('department_id', 'joining_date', 'phone', 'gender');

        if ($request->hasFile('joining_letter')) {
            $request->validate([
                'joining_letter' => 'required|mimes:doc,docx,txt,ppt,pptx,xls,xlsx,pdf,jpg,jpeg,png|max:2048',
            ]);

            $old_file = $teacher->joining_letter;
            $data['joining_letter'] = $this->uploadOne($request->file('joining_letter'), 'joining_letters');
            $this->deleteOne($old_file);
        }
        if ($request->hasFile('resume')) {
            $request->validate([
                'resume' => 'sometimes|nullable|mimes:doc,docx,txt,ppt,pptx,xls,xlsx,pdf,jpg,jpeg,png|max:2048',
            ]);
            $old_file = $teacher->resume;
            $data['resume'] = $this->uploadOne($request->file('resume'), 'resumes');
            $this->deleteOne($old_file);
        }

        $teacher->update($teacher_data);

        // Mail Send
        if ($request->password) {
            checkSetup() ? Mail::to($user->email)->send(new SendLoginCredentialMail($user, $request->password)) : '';
        }

        return responseSuccess('teacher', $teacher, 'Teacher update successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function destroy(Staff $teacher)
    {
        //Need Improvements
        $this->deleteOne($teacher->joining_letter);
        $this->deleteOne($teacher->resumes);

        $teacher->user()->delete();
        $teacher->delete();

        return responseSuccess('staff', null, 'Teacher delete successfully!');
    }

    public function getAllTeacher()
    {
        $staffs = Staff::where('designation', 'teacher')
            ->with('user:name,id')
            ->get();

        return $staffs;
    }
}
