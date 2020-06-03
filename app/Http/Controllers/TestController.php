<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use App\Subject;
use App\Test;
use App\TestVersion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use function GuzzleHttp\Promise\all;

class TestController extends BaseController
{
    private $validatorRules = [
        'name' => 'required',
//        'subject' => 'required'
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $user_id = Auth::user()->getAuthIdentifier();
//        $tests = Test::where('user_id', $user_id)->get();
        $test = new Test();
        return $this->sendResponse($test->findAllByUser(), 'All tests are retrieved successfully');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make( $input, $this->validatorRules);

        if($validator->fails()){
            return $this->sendError($validator->errors());
        }
        $input['user_id'] = Auth::user()->getAuthIdentifier();
        $test = Test::create($input);
        return $this->sendResponse($test, 'Test created successfully', 201);

    }

    /**
     * Display the specified resource.
     *
     * @param int $test_id
     * @return \Illuminate\Http\Response
     */
    public function show(Test $test)
    {
        $q = Question::find(3);
        dd($q->test);
        return $this->sendResponse($test, 'Test retrieved successfully ');
    }

    public function update(Request $request, Test $test)
    {
//        $test = Test::find($test_id);
//        if(is_null($test))
//            return $this->sendError('Test not found');
        $input = $request->all();
        $validator = Validator::make( $input, $this->validatorRules);
        if($validator->fails()){
            return $this->sendError($validator->errors());
        }
        $test->update($input);
        return $this->sendResponse($test, 'Test updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function destroy(Test $test)
    {
        if(is_null($test))
            return $this->sendError('Test not found');
        $test->delete();
        return $this->sendResponse($test, 'Test deleted successfully.');
    }

    public function showFullTest(Test $test)
    {
        $test = Test::where('id', $test->id)
            ->with('questions.answers')
            ->first();

        if(is_null($test))
            return $this->sendError('Test no found');

        return $this->sendResponse($test, 'Full Test retrieved successfully.');
    }

    public function storeFullTest(Request $request)
    {
        $request->merge(['user_id' => Auth::user()->getAuthIdentifier()]);
        $test = TEST::saveFullTest($request);
        return $test;
    }

    public function testsBySubject(Test $test, $subject){
        $tests = Test::where('subject', $subject)->get();
        return $this->sendResponse($tests, "Tests of $subject retrieved successfully ");
    }


}
