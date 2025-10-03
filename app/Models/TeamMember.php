<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    protected $table = 'team_member';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];
}
