<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    //
    protected $fillable = ['project_name'];

    public function issues()
    {
        return $this->hasMany(Issue::class);
    }

    public function users()
    {
        return $this->belongsToMany('User');
    }
}
