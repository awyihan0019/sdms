<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    //
    protected $fillable = ['project_name'];

    public function users()
    {
        return $this->belongsToMany(\App\User::class)->withTimeStamps();
    }

    public function issues()
    {
        return $this->hasMany(\App\Issue::class, 'project_id');
    }

    public function histories()
    {
        return $this->hasMany(\App\History::class, 'project_id');
    }
}
