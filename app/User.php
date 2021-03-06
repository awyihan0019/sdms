<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function projects()
    {
        return $this->belongsToMany(\App\Project::class)->withTimeStamps()->withPivot('role');
    }

    public function postedIssue()
    {
        return $this->hasMany(\App\Issue::class, 'post_user_id');
    }

    public function AssignedIssue()
    {
        return $this->hasMany(\App\Issue::class, 'assigned_user_id');
    }

    public function comments()
    {
        return $this->hasMany(\App\Comment::class);
    }

    public function histories()
    {
        return $this->hasMany(\App\History::class, 'user_id');
    }

    public function attachments()
    {
        return $this->hasMany(\App\Attachment::class, 'uploaded_user_id');
    }
}
