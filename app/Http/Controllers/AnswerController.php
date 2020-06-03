<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AnswerController extends BaseController
{
    private $validatorRules = [
        'content' => 'required',
        'is_true' => 'required|boolean'
    ];

    /**
     * Display a listing of the resource.
     *
     * @param Question $question
     * @return \Illuminate\Http\Response
     */
    public function index(Question $question)
    {
        $answers = Answer::where('question_id', $question->id)->get();
        return $this->sendResponse($answers, 'All Answers are retrieved successfully');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Question $question
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Question $question)
    {

        $input = $request->all();
        $input += [
            'question_id'=> $question->id,
            'user_id' => Auth::user()->getAuthIdentifier()
        ];
        $validator = Validator::make( $input, $this->validatorRules);

        if($validator->fails())
            return $this->sendError($validator->errors());

        $answer = Answer::create($input);
//        dd($answer);
        return $this->sendResponse($answer, 'Answer created successfully', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function show(Answer $answer)
    {
          return $this->sendResponse($answer, 'Answer retrieved successfully ');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Answer $answer)
    {
        $input = $request->all();
        $validator = Validator::make( $input, $this->validatorRules);
        if($validator->fails())
            return $this->sendError($validator->errors());

        $answer->update($input);
        return $this->sendResponse($answer, 'Answer updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Answer $answer)
    {
        $answer->delete();
        return $this->sendResponse(null, 'Answer deleted successfully.', 204);
    }


}
