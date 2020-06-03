<?php

namespace App\Http\Controllers;

use App\Test;
use App\Question;
use App\Answer;
use App\TestVersion;
use App\Version;
// use Barryvdh\DomPDF\PDF;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade as PDF;


class TestVersionController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @param Test $test
     * @return Response
     */
    public function index(Test $test)
    {

        $testVersions = $test->testVersions()->get();
        $testVersions->map(function ($version, $key){
            $parsedTest = json_decode($version->content, true);
            $version['test_name'] = $parsedTest['name'];
            return $version;
        });
        $testVersions->makeHidden('content');
        if ($testVersions->isEmpty())
            return $this->sendError(['Test version not found'], 404);
        return $this->sendResponseJson($testVersions, 'All Tests Version are retrieved successfully');
    }

     /**
      * @param Test $test
      * @param Request $request
      * @return Response
      */
     public function generateTestVersion(Test $test, Request $request)
     {
         $input = $request->all();
         $validator = Validator::make( $input, [
             'name' => 'required',
         ]);
         if($validator->fails())
             return $this->sendError($validator->errors());

         $testVersion = [];
         $testVersion['test_id']= $test->id;
         $testVersion['name'] = $input['name'];
         $fullTest = $test->getNested()->toArray();

         shuffle($fullTest[0]['questions']);
         foreach ($fullTest[0]['questions'] as &$question)
         {
             shuffle($question['answers']);
         }

         $testVersion['content'] = json_encode($fullTest[0]);
         $savedVersion = TestVersion::create($testVersion);
         $savedVersion->makeHidden('content');
         $savedVersion['test_name']=$test->name;

         return $this->sendResponse($savedVersion, 'Test generated successfully', 200);
     }


    /**
     * Display the specified resource.
     *
     * @param \App\TestVersion $testVersion
     * @return Response
     */
    public function show(TestVersion $testVersion)
    {
        $testVersion->content = json_decode($testVersion->content, true);
        return $this->sendResponse($testVersion, 'Test Version retrieved successfully');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param \App\TestVersion $testVersion
     * @return Response
     * @throws \Exception
     */
    public function destroy(TestVersion $testVersion)
    {
        $testVersion->delete();
        return $this->sendResponse(null,'Test Version delete successfully', 204);
    }

    /**
     * @param TestVersion $testVersion
     * @return mixed
     */
    public function generateTestPdf(TestVersion $testVersion)
    {
        $testVersion = $testVersion->getById($testVersion->id)->toArray();
        $data = ['version' => $testVersion];
        $pdf = PDF::loadView('test', $data);
        return  $pdf->download($testVersion['content']['name'].' (test) - '.$testVersion['name'] .'.pdf');
    }

    /**
     * @param TestVersion $testVersion
     * @return mixed
     */
    public function generateQuestionSheetPdf (TestVersion $testVersion)
    {
        $testVersion = $testVersion->getById($testVersion->id)->toArray();
        $data = ['version' => $testVersion];
        $pdf = PDF::loadView('questionSheet', $data);
        return $pdf->download($testVersion['content']['name'].' (questions sheet) - '.$testVersion['name'] .'.pdf');

    }

    /**
     * @param TestVersion $testVersion
     * @return mixed
     */
    public function generateCheckSheetPdf(TestVersion $testVersion)
    {
        $testVersion = $testVersion->getById($testVersion->id)->toArray();
        $data = ['version' => $testVersion];
        $pdf = PDF::loadView('checkSheet', $data);
        return $pdf->download($testVersion['content']['name'].' (check sheet) - '.$testVersion['name'] .'.pdf');
    }


}
