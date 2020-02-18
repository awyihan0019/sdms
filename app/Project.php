<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    //
    protected $fillable = ['project_name'];

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimeStamps();
    }

    public function issues()
    {
        return $this->hasMany(\App\Issue::class);
    }
}
