<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubjectRequest;
use App\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subject = new Subject();
        $subjects = $subject->findAllByUser();
        return $subjects;
//        return $this->sendResponse($subjects['data'], 'All Subjects are retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubjectRequest $request)
    {
        $userId = Auth::user()->getAuthIdentifier();
        $request->merge(['user_id' => $userId]);
        $subject = Subject::create($request->all());
//        dd($request->rules());
        return $subject;
//        return $this->sendResponse($subject, "Subject created successfully.", 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, Subject $subject)
    {
        if ($user->can('access', $subject)) {
            $subject->delete();
        }
//        return $this->sendResponse(null, 'Subject deleted successfully.', 204);
    }
}
