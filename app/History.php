<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    //
    protected $fillable = [
        'user_id', 'issue_id', 'project_id', 'comment_id', 'action_log',
    ];

    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    public function project()
    {
        return $this->belongsTo(\App\Project::class);
    }

    public function issue()
    {
        return $this->belongsTo(\App\Issue::class);
    }

    public function comment()
    {
        return $this->belongsTo(\App\Comment::class);
    }
}
