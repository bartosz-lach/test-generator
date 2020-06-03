<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\DocBlock\Tags\Author;

class Subject extends Model
{
    protected $fillable = ['name', 'user_id'];
    public $timestamps = false;

    public function findAllByUser(){
        $userId = Auth::user()->getAuthIdentifier();
        $subjects = $this->where('user_id', $userId)->get();
        $subjects = $subjects->pluck('name');

        return $subjects;
    }

}
