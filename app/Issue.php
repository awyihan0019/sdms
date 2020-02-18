<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    //
    protected $fillable = ['type', 'subject', 'description', 'priority', 'severity', 'category', 'version', 'due_date', 'status'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function users()
    {
        return $this->belongsToMany('User');
    }
}
