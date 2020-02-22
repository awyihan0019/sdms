<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
    protected $fillable = ['comment_user_id', 'issue_id', 'content'];

    public function commented_user()
    {
        return $this->belongsTo(\App\User::class);
    }

    public function issue()
    {
        return $this->belongsTo(\App\Issue::class);
    }
}
