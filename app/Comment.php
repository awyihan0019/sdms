<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
    protected $fillable = ['comment_user_id', 'issue_id', 'content'];

    public function commented_user()
    {
        return $this->belongsTo(\App\User::class, 'comment_user_id');
    }

    public function issue()
    {
        return $this->belongsTo(\App\Issue::class, 'issue_id');
    }

    public function history()
    {
        return $this->hasOne(\App\History::class, 'comment_id');
    }
}
