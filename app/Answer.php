<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = ['user_id', 'question_id', 'content', 'is_true'];
    protected $hidden = ['user_id', 'question_id'];
    public $timestamps = false;

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
