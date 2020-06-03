<?php

namespace Service;

use App\Answer;
use App\Question;
use App\Test;
use Illuminate\Support\Facades\DB;

class testVersionGenerator
{
    public function getTest(int $test_id)
    {
        $test = DB::table('tests')
//            ->where('id', $test_id)
            ->join('questions', 'tests.id', '=', 'questions.test_id')
            ->select('tests.*', 'questions.content' )
            ->get();

        dd($test);
    }
}
