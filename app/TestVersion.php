<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TestVersion extends Model
{
    protected $fillable = ['test_id', 'name', 'content'];
    public $timestamps = false;


    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    public function getAllByTestId(int $testId)
    {
        $versions = $this->where('test_id', $testId)->get()->toArray();

        foreach ($versions as $v)
        {
            $v['content'] = json_decode($v['content'] , true);
        }
        return $versions;
    }



    public  function getById(int $testVersionId)
    {
        $version =  $this->find($testVersionId);

        $version->content =  json_decode($version->content, true);

        return $version;
    }
}
