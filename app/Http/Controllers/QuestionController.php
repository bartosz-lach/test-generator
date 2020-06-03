<?php

namespace App\Http\Controllers;

use App\Question;
use App\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class QuestionController extends BaseController
{
    private $validatorRules = [
        'content' => 'required'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Test $test)
    {

        $questions = Question::where('test_id', $test->id)->get();
        return $this->sendResponse($questions, 'Questions are retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Test $test
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Test $test)
    {
        $input = $request->all();
        $validator = Validator::make( $input, $this->validatorRules);

        if($validator->fails())
            return $this->sendError($validator->errors());

        $input += [
            'test_id' => $test->id,
            'user_id' => Auth::user()->getAuthIdentifier()
        ];

        $question = Question::create($input);
        return $this->sendResponse($question, 'Question created successfully', 201);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        return  $this->sendResponse($question, 'Question retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        $input = $request->all();
        $validator = Validator::make( $input, $this->validatorRules);
        if($validator->fails())
            return $this->sendError($validator->errors());
        $question->update($input);
        return $this->sendResponse($question, 'Question updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Question $question
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Question $question)
    {
        $question->delete();
        return $this->sendResponse($question, 'Question deleted successfully', 204);
    }
}
