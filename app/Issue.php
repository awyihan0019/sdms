<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    //
    protected $fillable = ['project_id', 'type', 'subject', 'description', 'priority', 'severity', 'category', 'version', 'due_date', 'status', 'post_user_id', 'assigned_user_id'];

    public function project()
    {
        return $this->belongsTo(\App\Project::class);
    }

    public function postedUser()
    {
        return $this->belongsTo(\App\User::class);
    }

    public function assignedUser()
    {
        return $this->belongsTo(\App\User::class);
    }

    public function comments()
    {
        return $this->hasMany(\App\Comment::class, 'issue_id');
    }
}
