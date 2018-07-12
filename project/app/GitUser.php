<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GitUser extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'github_user_id', 'login', 'node_id', 'url', 'image_path', 'description'
    ];

    protected $hidden = [
        'github_user_id', 'node_id'
    ];
}
