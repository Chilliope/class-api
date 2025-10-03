<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardAdminTeamMemberController extends Controller
{
    // Add user to team
    public function addUserToTeam(Request $request, $teamId)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $team = Team::find($teamId);

        if (!$team) {
            return response()->json([
                'message' => 'Team not found'
            ], 404);
        }

        // attach user to team (avoid duplicate with syncWithoutDetaching)
        $team->users()->syncWithoutDetaching([$request->user_id]);

        return response()->json([
            'message' => 'User added to team successfully',
            'team' => $team->load('users')
        ]);
    }

    // Remove user from team
    public function removeUserFromTeam($teamId, $userId)
    {
        $team = Team::find($teamId);

        if (!$team) {
            return response()->json([
                'message' => 'Team not found'
            ], 404);
        }

        $team->users()->detach($userId);

        return response()->json([
            'message' => 'User removed from team successfully',
            'team' => $team->load('users')
        ]);
    }
}
