<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $table = 'teams';
    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'team_user');
    }

    public function posts()
    {
        return $this->hasMany(TeamPost::class);
    }

}
