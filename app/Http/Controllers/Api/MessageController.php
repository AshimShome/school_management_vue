<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Message;
use App\Models\Student;
use App\Models\Guardian;
use Illuminate\Http\Request;
use Nexmo\Laravel\Facade\Nexmo;
use App\Http\Controllers\Controller;
use App\Mail\MessageMail;
use App\Notifications\MessageNotification;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;

class MessageController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_type'     =>  ['required'],
            'title'       =>  ['required'],
            'message'       =>  ['required'],
        ]);

        Role::find($request->user_type)->users->each(function ($user) use ($request) {
            $user->notify(new MessageNotification($user->name, auth()->user(), $request->title, $request->message));
        });

        return responseSuccess(null, null, 'Message Notification Send successfully');
    }

    public function messageSending(Request $request)
    {
        if ($request->user_type == 'student') {
            $students = Student::with('user')->get();
            foreach ($students as $student) {
                $message = $student->messages()->create($request->only(['message', 'message_type']));
                if ($request->message_type == 'email') {
                    checkSetup() ? Mail::to($student->user->email)->send(new MessageMail($student->user, $message, $request->user_type)) : '';
                } else {
                    Nexmo::message()->send([
                        'to'   => '', //Need valid phone number
                        'from' => env('SMS_FROM'),
                        'text' => $message->message
                    ]);
                }
            }
        } else {
            $guardians = Guardian::with('user')->get();
            foreach ($guardians as $guardian) {
                $message = $guardian->messages()->create($request->only(['message', 'message_type']));
                if ($request->message_type == 'email') {
                    checkSetup() ? Mail::to($guardian->user->email)->send(new MessageMail($guardian->user, $message, $request->user_type)) : '';
                } else {
                    Nexmo::message()->send([
                        'to'   => '', //Need valid phone number
                        'from' => env('SMS_FROM'),
                        'text' => $message->message
                    ]);
                }
            }
        }
    }

    /**
     * Get messages by user_type & message_type
     */
    public function getMessageByUserTypeAndMessageType(Request $request)
    {
        $request->validate([
            'user_type'     =>  ['required', 'in:student,guardian'],
            'message_type'     =>  ['required', 'in:email,sms'],
        ]);

        $messages = Message::with('user:name,id')->where('message_type', $request->message_type)->where(function ($q) {
            $type = sprintf('App\Models\%s', ucfirst(request('user_type')));
            $q->where('messageable_type', $type);
        })->get();

        return responseSuccess('messages', $messages);
    }

    public function getRoles()
    {
        return response()->json([
            'roles' => Role::where('id', '!=', 1)->get(['id', 'name'])
        ]);
    }
}
