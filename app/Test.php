<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Test extends Model
{
    protected $fillable = ['questions', 'user_id', 'subject', 'name' ];
    protected $hidden = ['created_at', 'updated_at', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function testVersions()
    {
        return $this->hasMany(TestVersion::class);
    }

    public function subject(){
        return $this->belongsTo(Subject::class);
    }

    public function getNested()
    {
        return $this->where('id',$this->id)
            ->with('questions.answers')
            ->get();
//            ->first();
    }

    public function findAllByUser(){
        $userId = Auth::user()->getAuthIdentifier();
        return $this->where('user_id', $userId)->get();
    }


    public static function saveFullTest(Request $request )
    {
        $testFromRequest= $request->all();

        $test = TEST::create($request->except('questions'));
        foreach ($testFromRequest['questions'] as $question) {
            $questionFromDb = QUESTION::create([
                'user_id' => $test->user_id,
                'test_id' => $test->id,
                'content' => $question['content']
            ]);
            $answersToSend = array();
            foreach ($question['answers'] as $answer){
                $answersToSend[] = [
                    'user_id' => $test->user_id,
                    'question_id' => $questionFromDb->id,
                    'content' => $answer['content'],
                    'is_true' => $answer['is_true']
                ];
            }
            DB::table('answers')->insert($answersToSend);
        }
    }

    public static function updateFullTest(Test $test, Request $request )
    {

        $test->update($request->all());
        $test->update($request->except('questions'));
        foreach ($test['questions'] as $question) {
            $questionFromDb = $question->update([
                'user_id' => $test->user_id,
                'test_id' => $test->id,
                'content' => $question['content']
            ]);
            $answersToSend = array();
            foreach ($question['answers'] as $answer){
                $answersToSend[] = [
                    'user_id' => $test->user_id,
                    'question_id' => $questionFromDb->id,
                    'content' => $answer['content'],
                    'is_true' => $answer['is_true']
                ];
            }
            DB::table('answers')->updateOrInsert($answersToSend);
        }
    }
}
