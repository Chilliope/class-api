<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamPost extends Model
{
    protected $table = 'team_posts';
    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
