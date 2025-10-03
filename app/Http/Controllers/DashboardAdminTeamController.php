<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;

class DashboardAdminTeamController extends Controller
{
    // GET /api/team
    public function index()
    {
        $teams = Team::all();
        return response()->json([
            'message' => 'Teams retrieved successfully',
            'data' => $teams
        ]);
    }

    // GET /api/team/{id}
    public function show($id)
    {
        $team = Team::find($id);

        if (!$team) {
            return response()->json([
                'message' => 'Team not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Team retrieved successfully',
            'data' => $team
        ]);
    }

    // POST /api/team
    public function store(Request $request)
    {
        $request->validate([
            'team'   => 'required|string|max:255',
            'desc'   => 'required|string',
            'image'  => 'nullable|string',
            'banner' => 'nullable|string',
        ]);

        $team = Team::create($request->all());

        return response()->json([
            'message' => 'Team created successfully',
            'data' => $team
        ], 201);
    }

    // PUT /api/team/{id}
    public function update(Request $request, $id)
    {
        $team = Team::find($id);

        if (!$team) {
            return response()->json([
                'message' => 'Team not found'
            ], 404);
        }

        $request->validate([
            'team'   => 'sometimes|required|string|max:255',
            'desc'   => 'sometimes|required|string',
            'image'  => 'nullable|string',
            'banner' => 'nullable|string',
        ]);

        $team->update($request->all());

        return response()->json([
            'message' => 'Team updated successfully',
            'data' => $team
        ]);
    }

    // DELETE /api/team/{id}
    public function destroy($id)
    {
        $team = Team::find($id);

        if (!$team) {
            return response()->json([
                'message' => 'Team not found'
            ], 404);
        }

        $team->delete();

        return response()->json([
            'message' => 'Team deleted successfully'
        ]);
    }
}
