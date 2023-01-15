<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Session;
use App\Models\AdminSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SessionRequest;
use App\Http\Resources\Session\SessionResource;
use App\Models\Classs;

class SessionController extends Controller
{
    /**
     * Get all session year.
     *
     * @return \Illuminate\Http\Response
     */
    public function getSessionYear()
    {
        return response()->json(
            [
                'sessions' => Session::latest()->get(['id', 'name']),
                'selectedSession' => AdminSetting::with('session:id,name')->first('default_session_id'),
            ]
        );
    }

    /**
     * Get all session year.
     *
     * @return \Illuminate\Http\Response
     */
    public function setSessionYear($session_id)
    {
        AdminSetting::first()->update(['default_session_id' => $session_id]);
        return response()->json(['message' => 'Academic Session year updated successfully.']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sessions = Session::latest()->get();

        return SessionResource::collection($sessions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  SessionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SessionRequest $request)
    {
        $session = Session::create($request->all());

        return responseSuccess('session', $session, 'Session create successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Session  $session
     * @return \Illuminate\Http\Response
     */
    public function show(Session $session)
    {
        return new SessionResource($session);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  SessionRequest  $request
     * @param  \App\Models\Session  $session
     * @return \Illuminate\Http\Response
     */
    public function update(SessionRequest $request, Session $session)
    {
        $session->update($request->all());

        return responseSuccess('session', $session, 'Session update successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Session  $session
     * @return \Illuminate\Http\Response
     */
    public function destroy(Session $session)
    {
        $session->delete();

        return responseSuccess(null, 'Session delete successfully!');
    }

    public function getCurrentSession()
    {
        return Session::select('id', 'name')->findOrFail(currentSession());
    }

    public function getClasses($session_id)
    {
        $classes = Classs::whereSessionId($session_id)->get();
        return response()->json(['classes' => $classes]);
    }
}
