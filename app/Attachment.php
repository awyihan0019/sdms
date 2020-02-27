<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    //
    protected $fillable = ['uploaded_user_id', 'attached_issue_id', 'file_name', 'path'];

    public function attached_issue()
    {
        return $this->belongsTo(\App\Issue::class);
    }

    public function uploaded_user()
    {
        return $this->belongsTo(\App\User::class);
    }
}
